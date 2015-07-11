<?php

namespace Bit2Bit\FrontBundle\FrontBundle\Controller;

use Bit2Bit\OfferBundle\Entity\Offer;
use Bit2Bit\OfferBundle\Manager\OfferManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteOfferController extends Controller {

    public function offersFlatsAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $session = $this->get('session');
        $searchTerms = array(
            'object_type' => 'flat'
        );
        $session->set('searchTerms',$searchTerms);
        $offers = $offerManager->searchOffers($searchTerms); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'mieszkania'));
    }
    
    public function offersHousesAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $session = $this->get('session');
        $searchTerms = array(
            'object_type' => 'house'
        );
        $session->set('searchTerms',$searchTerms);
        $offers = $offerManager->searchOffers($searchTerms); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'domy'));
    }
    
    public function offersPlotsAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $session = $this->get('session');
        $searchTerms = array(
            'object_type' => 'plot'
        );
        $session->set('searchTerms',$searchTerms);
        $offers = $offerManager->searchOffers($searchTerms); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'działki'));
    }
    
    public function offersLocalesAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $session = $this->get('session');
        $searchTerms = array(
            'object_type' => 'locale'
        );
        $session->set('searchTerms',$searchTerms);
        $offers = $offerManager->searchOffers($searchTerms); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'lokale'));
    }
    
    public function offersForSaleAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $session = $this->get('session');
        $searchTerms = array(
            'rent' => false
        );
        $session->set('searchTerms',$searchTerms);
        $offers = $offerManager->searchOffers($searchTerms); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'sprzedaż'));
    }
    
    public function offersForRentAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $session = $this->get('session');
        $searchTerms = array(
            'rent' => true
        );
        $session->set('searchTerms',$searchTerms);
        $offers = $offerManager->searchOffers($searchTerms); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'wynajem'));
    }
    
    public function offersSpecialAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $session = $this->get('session');
        $searchTerms = array(
            'hotOffer' => true
        );
        $session->set('searchTerms',$searchTerms);
        $offers = $offerManager->searchOffers($searchTerms); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'oferty specjalne'));
    }

}
