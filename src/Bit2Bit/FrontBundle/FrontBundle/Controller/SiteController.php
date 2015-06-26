<?php

namespace Bit2Bit\FrontBundle\FrontBundle\Controller;

use Bit2Bit\CmsBundle\Entity\Partner;
use Bit2Bit\CmsBundle\Manager\PartnerManager;
use Bit2Bit\OfferBundle\Entity\Offer;
use Bit2Bit\OfferBundle\Manager\OfferManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller {

    public function indexAction() {
        $partnerManager = $this->get(PartnerManager::SERVICE); /* @var $partnerManager PartnerManager */
        $partners = $partnerManager->findAll(); /* @var $partners Partner[] */
        return $this->render('FrontBundle:Site:index.html.twig', array('partners' => $partners));
    }

    public function offersAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findBy(array('published' => true)); /* @var $offers Offer[] */

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers, 'title' => 'nieruchomości'));
    }

    public function offerAction($id) {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = $offerManager->find($id); /* @var $offer Offer */

        if (!$offer) {
            return $this->createNotFoundException('Nie znaleźliśmy oferty z takim identyfikatorem! ;(');
        }

        if (!$offer->getPublished()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if (!$user) {
                return $this->createNotFoundException('Nie znaleźliśmy oferty z takim identyfikatorem! ;(');
            }
        }
        return $this->render('FrontBundle:Site:offer.html.twig', array('offer' => $offer));
    }

    public function advicePageAction() {
        return $this->render('FrontBundle:Site:advice.html.twig');
    }

    public function searchAction(Request $request) {
        $data = $request->request->all();

        if (!empty($data)) {
            $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
            $offers = $offerManager->searchOffers($data); /* @var $offers Offer[] */
        } else {
            $offers = array();
        }

        return $this->render('FrontBundle:Site:offers.html.twig', array('offers' => $offers, 'title' => 'wyniki wyszukiwania'));
    }

}
