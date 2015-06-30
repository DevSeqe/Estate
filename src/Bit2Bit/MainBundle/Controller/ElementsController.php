<?php

namespace Bit2Bit\MainBundle\Controller;

use Bit2Bit\ContactBundle\Manager\MailManager;
use Bit2Bit\MainBundle\Base\MenuGenerator;
use Bit2Bit\OfferBundle\Entity\Offer;
use Bit2Bit\OfferBundle\Manager\OfferManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ElementsController extends Controller {

    public function menuAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $menuGenerator = new MenuGenerator($user);
        
        $mailManager = $this->get(MailManager::SERVICE); /* @var $mailManager MailManager */
        $unread = $mailManager->countUnread($user);

        $menuGenerator->add('Pulpit', 'panel_dashboard', 'fa fa-dashboard')
                ->add('Użytkownicy', 'panel_users', 'fa fa-group')
                ->add('Oferty', 'user_offer', 'fa fa-home')
                ->add('Lokalizacje', 'user_localization', 'fa fa-map-marker')
                ->add('Wiadomości', 'user_mail', 'fa fa-envelope-o', false, $unread)
                ->add('Partnerzy', 'partner', 'fa fa-suitcase', 'ROLE_ADMIN')
                ->add('Subskrybenci', 'admin_subscriber', 'fa fa-at', 'ROLE_ADMIN')
                ->add('Newsletter', 'admin_message', 'fa fa-envelope', 'ROLE_ADMIN')
                ->add('CMS', 'page', 'fa fa-files-o', 'ROLE_ADMIN')
                ->add('Dyplomy', 'page_diploma', 'fa fa-mortar-board', 'ROLE_ADMIN')
                ->add('Ustawienia', 'admin_settings', 'fa fa-cogs', 'ROLE_ADMIN');


        return $this->render('MainBundle:Elements:menu.html.twig', array('menu' => $menuGenerator->getMenu()));
    }

    public function searchAction() {
        return $this->render('MainBundle:Elements:search.html.twig');
    }

    public function newestAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findNewest(); /* @var $offers Offer[] */
        return $this->render('MainBundle:Elements:newest.html.twig', array('newest' => $offers));
    }

}
