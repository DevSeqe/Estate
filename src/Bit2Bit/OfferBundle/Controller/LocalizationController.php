<?php

namespace Bit2Bit\OfferBundle\Controller;

use Bit2Bit\MainBundle\Base\AbstractController;
use Bit2Bit\NewsletterBundle\Entity\Message;
use Bit2Bit\NewsletterBundle\Entity\Subscriber;
use Bit2Bit\NewsletterBundle\Form\MessageType;
use Bit2Bit\NewsletterBundle\Manager\MessageManager;
use Bit2Bit\NewsletterBundle\Manager\SubscriberManager;
use Bit2Bit\OfferBundle\Entity\Localization;
use Bit2Bit\OfferBundle\Form\LocalizationType;
use Bit2Bit\OfferBundle\Manager\LocalizationManager;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;

class LocalizationController extends AbstractController {

    const NAME = 'OfferBundle:Localization';

    public function indexAction() {
        $localizationManager = $this->get(LocalizationManager::SERVICE); /* @var $localizationManager LocalizationManager */
        $localizations = $localizationManager->findAll(); /* @var $localization Localization */
        return $this->render(self::NAME . ':index.html.twig', array('localizations' => $localizations));
    }

    public function newAction(Request $request) {
        $localizationManager = $this->get(LocalizationManager::SERVICE); /* @var $localizationManager LocalizationManager */
        $localization = new Localization();

        $form = $this->createForm(new LocalizationType(), $localization, array(
            'action' => $this->generateUrl('user_localization_new'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $session = $this->get('session');
            $localizationManager->persist($localization)
                    ->flush();
            $session->getFlashBag()->add('success', 'Dodano nową lokalizację.');
            return $this->redirect($this->generateUrl('user_localization'));
        }
        return $this->render(self::NAME . ':new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id) {
        $localizationManager = $this->get(LocalizationManager::SERVICE); /* @var $localizationManager LocalizationManager */
        $localization = $localizationManager->find($id); /* @var $localization Localization */
        $session = $this->get('session');

        if (!$localization) {
            $session->getFlashBag()->add('danger', 'Nie odnaleziono wskazanej lokalizacji.');
            return $this->redirect($this->generateUrl('user_localization'));
        }

        $form = $this->createForm(new LocalizationType(), $localization, array(
            'action' => $this->generateUrl('user_localization_edit', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $localizationManager->update($localization);
            $session->getFlashBag()->add('success', 'Zaktualizowano lokalizację.');
            return $this->redirect($this->generateUrl('user_localization'));
        }
        return $this->render(self::NAME . ':edit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function removeAction($id) {
        $localizationManager = $this->get(LocalizationManager::SERVICE); /* @var $localizationManager LocalizationManager */
        $localization = $localizationManager->find($id); /* @var $localization Localization */
        $session = $this->get('session');

        if (!$localization) {
            $session->getFlashBag()->add('danger', 'Nie znaleziono lokalizacji.');
        } else {
            $localizationManager->remove($localization);
            $session->getFlashBag()->add('success', 'Pomyślnie usunięto lokalizację.');
        }

        return $this->redirect($this->generateUrl('user_localization'));
    }

}
