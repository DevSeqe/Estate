<?php

namespace Bit2Bit\NewsletterBundle\Controller;

use Bit2Bit\MainBundle\Base\AbstractController;
use Bit2Bit\NewsletterBundle\Entity\Subscriber;
use Bit2Bit\NewsletterBundle\Form\SubscriberType;
use Bit2Bit\NewsletterBundle\Manager\SubscriberManager;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class SubscriberController extends AbstractController {

    const NAME = 'NewsletterBundle:Subscriber';

    public function indexAction() {
        $subscriberManager = $this->get(SubscriberManager::SERVICE); /* @var $subscriberManager SubscriberManager */
        $subscribers = $subscriberManager->findAll(); /* @var $subscribers Subscriber[] */
        return $this->render(self::NAME . ':index.html.twig', array('subscribers' => $subscribers));
    }

    public function newAction(Request $request) {
        $subscriberManager = $this->get(SubscriberManager::SERVICE); /* @var $subscriberManager SubscriberManager */
        $subscriber = new Subscriber();

        $form = $this->createForm(new SubscriberType(), $subscriber, array(
            'action' => $this->generateUrl('admin_subscriber_new'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $now = new DateTime('NOW');
            $session = $this->get('session');
            $subscriber->setJoined($now);
            $subscriberManager->persist($subscriber)
                    ->flush();
            $session->getFlashBag()->add('success', 'Dodano nowego subskrybenta.');
            return $this->redirect($this->generateUrl('admin_subscriber'));
        }
        return $this->render(self::NAME . ':new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id) {
        $subscriberManager = $this->get(SubscriberManager::SERVICE); /* @var $subscriberManager SubscriberManager */
        $subscriber = $subscriberManager->find($id); /* @var $subscriber Subscriber */
        $session = $this->get('session');

        if (!$subscriber) {
            $session->getFlashBag()->add('danger', 'Nie odnaleziono wskazanego subskrybenta.');
            return $this->redirect($this->generateUrl('admin_subscribers'));
        }

        $form = $this->createForm(new SubscriberType(), $subscriber, array(
            'action' => $this->generateUrl('admin_subscriber_edit', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $subscriberManager->update($subscriber);
            $session->getFlashBag()->add('success', 'Zaktualizowano subskrybenta.');
            return $this->redirect($this->generateUrl('admin_subscriber'));
        }
        return $this->render(self::NAME . ':edit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function toggleAction($id) {
        $subscriberManager = $this->get(SubscriberManager::SERVICE); /* @var $subscriberManager SubscriberManager */
        $subscriber = $subscriberManager->find($id); /* @var $subscriber Subscriber */
        $session = $this->get('session');

        if (!$subscriber) {
            $session->getFlashBag()->add('danger', 'Nie odnaleziono wskazanego subskrybenta.');
            return $this->redirect($this->generateUrl('admin_subscribers'));
        }


        if ($subscriber->getActive()) {
            $subscriber->setActive(false);
            $session->getFlashBag()->add('success', 'Wyłączono subskrypcję dla adresu <strong>' . $subscriber->getEmail() . '</strong>.');
        } else {
            $subscriber->setActive(true);
            $session->getFlashBag()->add('success', 'Aktywowano subskrypcję dla adresu <strong>' . $subscriber->getEmail() . '</strong>.');
        }
        $subscriberManager->update($subscriber);
        return $this->redirect($this->generateUrl('admin_subscriber'));
    }

    public function subscribeAction(Request $request) {
        $data = $request->request->all();

        $validate = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $session = $this->get('session');

        $result = array('success' => $validate);
        if (!$validate) {
            $session->getFlashBag()->add('danger', 'Nieprawidłowy adres email.');
            return $this->json($result);
        }

        $subscriberManager = $this->get(SubscriberManager::SERVICE); /* @var $subscriberManager SubscriberManager */
        $subscriber = new Subscriber();
        $now = new DateTime('NOW');
        $subscriber->setName('')
                ->setEmail($data['email'])
                ->setActive(true)
                ->setJoined($now);
        $subscriberManager->persist($subscriber)
                ->flush();
        $session->getFlashBag()->add('success', 'Adres email dodano do subskrypcji.');
        return $this->json($result);
    }
    
    public function removeAction($id) {
        $subscriberManager = $this->get(SubscriberManager::SERVICE); /* @var $subscriberManager SubscriberManager */
        $subscriber = $subscriberManager->find($id); /* @var $subscriber Subscriber */
        $session = $this->get('session');
            
        if (!$subscriber) {
            $session->getFlashBag()->add('danger', 'Nie znaleziono subskrybenta.');            
        }
        else{
            $subscriberManager->remove($subscriber);
            $session->getFlashBag()->add('success', 'Pomyślnie usunięto subskrybenta.');                        
        }
        
        return $this->redirect($this->generateUrl('admin_subscriber'));
    }

}
