<?php

namespace Bit2Bit\NewsletterBundle\Controller;

use Bit2Bit\MainBundle\Base\AbstractController;
use Bit2Bit\NewsletterBundle\Entity\Message;
use Bit2Bit\NewsletterBundle\Entity\Subscriber;
use Bit2Bit\NewsletterBundle\Form\MessageType;
use Bit2Bit\NewsletterBundle\Manager\MessageManager;
use Bit2Bit\NewsletterBundle\Manager\SubscriberManager;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends AbstractController {

    const NAME = 'NewsletterBundle:Message';

    public function indexAction() {
        $messageManager = $this->get(MessageManager::SERVICE); /* @var $messageManager MessageManager */
        $messages = $messageManager->findAll(); /* @var $messages Message[] */
        return $this->render(self::NAME . ':index.html.twig', array('messages' => $messages));
    }

    public function newAction(Request $request) {
        $messageManager = $this->get(MessageManager::SERVICE); /* @var $messageManager MessageManager */
        $message = new Message();

        $form = $this->createForm(new MessageType(), $message, array(
            'action' => $this->generateUrl('admin_message_new'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $session = $this->get('session');
            $messageManager->persist($message)
                    ->flush();
            $session->getFlashBag()->add('success', 'Dodano nową wiadomość.');
            return $this->redirect($this->generateUrl('admin_message'));
        }
        return $this->render(self::NAME . ':new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id) {
        $messageManager = $this->get(MessageManager::SERVICE); /* @var $messageManager MessageManager */
        $message = $messageManager->find($id); /* @var $message Message */
        $session = $this->get('session');

        if (!$message) {
            $session->getFlashBag()->add('danger', 'Nie odnaleziono wskazanej wiadomości.');
            return $this->redirect($this->generateUrl('admin_messsage'));
        }

        $form = $this->createForm(new MessageType(), $message, array(
            'action' => $this->generateUrl('admin_message_edit', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $messageManager->update($message);
            $session->getFlashBag()->add('success', 'Zaktualizowano wiadomość.');
            return $this->redirect($this->generateUrl('admin_message'));
        }
        return $this->render(self::NAME . ':edit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function duplicateAction($id) {
        $messageManager = $this->get(MessageManager::SERVICE); /* @var $messageManager MessageManager */
        $message = $messageManager->find($id); /* @var $message Message */
        $session = $this->get('session');

        if (!$message) {
            $session->getFlashBag()->add('danger', 'Nie odnaleziono wskazanej wiadomości.');
            return $this->redirect($this->generateUrl('admin_message'));
        }

        $duplicate = clone $message;
        $duplicate->setName($duplicate->getName() . ' - Kopia');
        $messageManager->persist($duplicate)
                ->flush();
        $session->getFlashBag()->add('success', 'Skopiowano wiadomość <strong>' . $message->getName() . '</strong>.');
        return $this->redirect($this->generateUrl('admin_message'));
    }

    public function sendAction($id) {
        $messageManager = $this->get(MessageManager::SERVICE); /* @var $messageManager MessageManager */
        $message = $messageManager->find($id); /* @var $message Message */

        $session = $this->get('session');
        if (!$message) {
            $session->getFlashBag()->add('danger', 'Nie znaleziono wiaodmości.');
            return $this->redirect($this->generateUrl('admin_message'));
        }

        $subscriberManager = $this->get(SubscriberManager::SERVICE); /* @var $subscriberManager SubscriberManager */
        $subscribers = $subscriberManager->findAll(); /* @var $subscribers Subscriber[] */

        $counter = 0;
        foreach ($subscribers as $subscriber) {
            if ($subscriber->getActive()) {
                $mail = Swift_Message::newInstance()
                        ->setSubject($message->getName())
                        ->setFrom($this->container->getParameter('mailer_user'))
                        ->setTo($subscriber->getEmail())
                        ->setBody($message->getContent(), 'text/html'
                );
                $this->get('mailer')->send($mail);
                $counter++;
            }
        }

        if ($counter) {
            $session->getFlashBag()->add('success', 'Wysłano wiadomość do ' . $counter . ' subskrybentów.');
        } else {
            $session->getFlashBag()->add('warning', 'Brak aktywnych subskrybentów w bazie. Wiadomość nie została wysłana.');
        }
        return $this->redirect($this->generateUrl('admin_message'));
    }

    public function removeAction($id) {
        $messageManager = $this->get(MessageManager::SERVICE); /* @var $messageManager MessageManager */
        $message = $messageManager->find($id); /* @var $message Message */
        $session = $this->get('session');

        if (!$message) {
            $session->getFlashBag()->add('danger', 'Nie znaleziono wiadomości.');
        } else {
            $messageManager->remove($message);
            $session->getFlashBag()->add('success', 'Pomyślnie usunięto wiadomość.');
        }

        return $this->redirect($this->generateUrl('admin_message'));
    }

}
