<?php

namespace Bit2Bit\FrontBundle\FrontBundle\Controller;

use Bit2Bit\OfferBundle\Entity\Offer;
use Bit2Bit\OfferBundle\Manager\OfferManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteOfferController extends Controller {

    public function offersFlatsAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findBy(array('published' => true,'type'=>'flat')); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'mieszkania'));
    }
    
    public function offersHousesAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findBy(array('published' => true,'type'=>'house')); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'domy'));
    }
    
    public function offersPlotsAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findBy(array('published' => true,'type'=>'plot')); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'działki'));
    }
    
    public function offersLocalesAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findBy(array('published' => true,'type'=>'locale')); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'lokale'));
    }
    
    public function offersForSaleAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findBy(array('published' => true,'rent'=>false)); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'sprzedaż'));
    }
    
    public function offersForRentAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findBy(array('published' => true,'rent'=>true)); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'wynajem'));
    }
    
    public function offersSpecialAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findBy(array('published' => true,'hotOffer'=>true)); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers,'title'=>'oferty specjalne'));
    }

}
