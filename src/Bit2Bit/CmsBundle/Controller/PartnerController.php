<?php

namespace Bit2Bit\CmsBundle\Controller;

use Bit2Bit\CmsBundle\Entity\Partner;
use Bit2Bit\CmsBundle\Form\PartnerType;
use Bit2Bit\CmsBundle\Manager\PartnerManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PartnerController extends Controller {

    const NAME = 'CmsBundle:Partner';

    public function indexAction() {
        $partnerManager = $this->get(PartnerManager::SERVICE); /* @var $partnerManager PartnerManager */
        $partners = $partnerManager->findAll(); /* @var $partners Partner[] */
        return $this->render(self::NAME . ':index.html.twig', array('partners' => $partners));
    }

    public function newAction(Request $request) {
        $partnerManager = $this->get(PartnerManager::SERVICE); /* @var $partnerManager PartnerManager */
        $partner = new Partner();

        $form = $this->createForm(new PartnerType(), $partner, array(
            'action' => $this->generateUrl('partner_new'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $session = $this->get('session');
            $partnerManager->persist($partner)
                    ->flush();
            $session->getFlashBag()->add('success', 'Dodano nowego partnera.');
            return $this->redirect($this->generateUrl('partner'));
        }
        return $this->render(self::NAME . ':new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id) {
        $partnerManager = $this->get(PartnerManager::SERVICE); /* @var $partnerManager PartnerManager */
        $partner = $partnerManager->find($id); /* @var $partner Partner */

        $session = $this->get('session');

        if (!$partner) {
            $session->getFlashBag()->add('danger', 'Nie odnaleziono partnera.');
            return $this->redirect($this->generateUrl('partner'));
        }

        $form = $this->createForm(new PartnerType(), $partner, array(
            'action' => $this->generateUrl('partner_edit', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $partnerManager->update($partner);
            $session->getFlashBag()->add('success', 'Zaktualizowano partnera.');
            return $this->redirect($this->generateUrl('partner'));
        }
        return $this->render(self::NAME . ':edit.html.twig', array(
                    'form' => $form->createView(),
                    'partner' => $partner
        ));
    }
    
    public function removeAction($id) {
        $partnerManager = $this->get(PartnerManager::SERVICE); /* @var $partnerManager PartnerManager */
        $partner = $partnerManager->find($id); /* @var $partner Partner */
        $session = $this->get('session');

        if (!$partner) {
            $session->getFlashBag()->add('danger', 'Nie znaleziono partnera.');
        } else {
            $partnerManager->remove($partner);
            $session->getFlashBag()->add('success', 'Pomyślnie usunięto partnera.');
        }

        return $this->redirect($this->generateUrl('partner'));
    }

}
