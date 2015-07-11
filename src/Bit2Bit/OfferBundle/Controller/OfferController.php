<?php

namespace Bit2Bit\OfferBundle\Controller;

use Bit2Bit\ContactBundle\Entity\Mail;
use Bit2Bit\ContactBundle\Manager\MailManager;
use Bit2Bit\MainBundle\Base\AbstractController;
use Bit2Bit\OfferBundle\Entity\Offer;
use Bit2Bit\OfferBundle\Enum\MarketType;
use Bit2Bit\OfferBundle\Enum\Type;
use Bit2Bit\OfferBundle\Form\OfferType;
use Bit2Bit\OfferBundle\Manager\OfferManager;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

class OfferController extends AbstractController {

    const NAME = 'OfferBundle:Offer';

    public function indexAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findAll(); /* @var $offers Offer[] */
        return $this->render(self::NAME . ':index.html.twig', array('offers' => $offers));
    }
    
    public function infiniteAction(Request $request) {
        $data = $request->request->all();
        $offset = (isset($data['number'])) ? $data['number'] : false;
        $session = $this->get('session');
        $searchTerms = $session->get('searchTerms');
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */        
        if(empty($searchTerms)){
            $offers = $offerManager->findNext($offset); /* @var $offers Offer[] */            
        } else {
            $offers = $offerManager->searchOffers($searchTerms, $offset); /* @var $offers Offer[] */                        
        }
        return $this->render(self::NAME . ':infinite.html.twig', array('offers' => $offers));
    }

    public function toggleAction($id, $type) {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = $offerManager->find($id); /* @var $offer Offer */

        $session = $this->get('session');

        if (!$offer) {
            $session->getFlashBag()->add('danger', 'Nie znaleziono oferty.');
            return $this->redirect($this->generateUrl('user_offer'));
        }

        if (!in_array($type, array('hotOffer', 'rent', 'published'))) {
            $session->getFlashBag()->add('danger', 'Nieprawidłowy klucz przełącznika.');
            return $this->redirect($this->generateUrl('user_offer'));
        }

        switch ($type) {
            case 'hotOffer':
                if ($offer->getHotOffer()) {
                    $offer->setHotOffer(false);
                    $session->getFlashBag()->add('success', 'Oferta <strong>' . $offer->getName() . '</strong> nie jest już gorącą ofertą.');
                } else {
                    $offer->setHotOffer(true);
                    $session->getFlashBag()->add('success', 'Włączono status "Gorąca oferta" dla oferty <strong>' . $offer->getName() . '</strong>.');
                }
                break;
            case 'rent':
                if ($offer->getRent()) {
                    $offer->setRent(false);
                    $session->getFlashBag()->add('success', 'Oferta <strong>' . $offer->getName() . '</strong> jest teraz ofertą sprzedaży.');
                } else {
                    $offer->setRent(true);
                    $session->getFlashBag()->add('success', 'Oferta <strong>' . $offer->getName() . '</strong> jest teraz ofertą wynajmu.');
                }
                break;
            case 'published':
                if ($offer->getPublished()) {
                    $offer->setPublished(false);
                    $session->getFlashBag()->add('success', 'Oferta <strong>' . $offer->getName() . '</strong> została ukryta.');
                } else {
                    if ($offer->getLocalization() == null) {
                        $session->getFlashBag()->add('danger', 'Nie można opublikować oferty, która nie posiada lokalizacji.');
                    } else {
                        $offer->setPublished(true);
                        $session->getFlashBag()->add('success', 'Oferta <strong>' . $offer->getName() . '</strong> została opublikowana.');
                    }
                }
                break;
        }

        $offerManager->update($offer);
        return $this->redirect($this->generateUrl('user_offer'));
    }

    public function newAction() {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = new Offer();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $now = new DateTime('NOW');
        $slug = md5($now->getTimestamp());
        $offer
                ->setAgent($user)
                ->setArea(0)
                ->setFloor(0)
                ->setHotOffer(false)
                ->setName('Szkic - ' . $now->format('Y-m-d H:i:s'))
                ->setNumberOfFloors(0)
                ->setPricePerMeter(0)
                ->setTotalPrice(0)
                ->setPublished(false)
                ->setRent(false)
                ->setRooms(0)
                ->setSlug($slug)
                ->setType(Type::FLAT)
                ->setMarketType(MarketType::SECONDARY)
                ->setCreated($now)
                ->setWater('yes')
                ->setGas('yes')
                ->setSewerage('yes')
                ->setViews(array())
                ->setTotalViews(0);

        $offerManager->persist($offer)
                ->flush();

        return $this->redirect($this->generateUrl('user_offer_edit', array('id' => $offer->getId())));
    }

    public function editAction(Request $request, $id) {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = $offerManager->find($id); /* @var $offer Offer */
        $session = $this->get('session');

        if (!$offer) {
            $session->getFlashBag()->add('danger', 'Nie odnaleziono wskazanej oferty.');
            return $this->redirect($this->generateUrl('user_offer'));
        }

        $form = $this->createForm(new OfferType(), $offer, array(
            'action' => $this->generateUrl('user_offer_edit', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($offer->getCommition()) {
                $offer->setDiscount(0);
            }
            if($offer->getTotalPrice() != 0 && $offer->getArea() != 0){
                $offer->setPricePerMeter($offer->getTotalPrice() / $offer->getArea());
            } else {
                $offer->setPricePerMeter(0);
            }
            if ($offer->getLocalization()) {
                $offer->setSimilar($offerManager->findSimilar($offer));
            }
            $offerManager->update($offer);
            $session->getFlashBag()->add('success', 'Zaktualizowano ofertę.');
            return $this->redirect($this->generateUrl('user_offer'));
        }
        return $this->render(self::NAME . ':edit.html.twig', array(
                    'form' => $form->createView(),
                    'offer' => $offer
        ));
    }

    public function getPhotosAction($id) {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = $offerManager->find($id); /* @var $offer Offer */

        $result = array('result' => false);
        if (!$offer) {
            return $this->json($result);
        }

        $result['result'] = true;
        $result['photos'] = array();
        $photos = $offer->getPhotos();
        foreach ($photos as $photo) {
            $result['photos'][] = $photo;
        }

        return $this->json($result);
    }

    public function reorderPhotosAction(Request $request, $id) {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = $offerManager->find($id); /* @var $offer Offer */

        $result = array('result' => false);
        if (!$offer) {
            return $this->json($result);
        }

        $data = $request->request->all();

        if (!isset($data['ids'])) {
            return $this->json($result);
        }


        $result['result'] = true;
        $result['photos'] = array();
        $photos = $offer->getPhotos();
        $basePath = getcwd();
        $files = array();
        foreach ($photos as $photo) {
            $file = $basePath.$photo;
            $info = getimagesize($file);

            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($file);
            } elseif ($info['mime'] == 'image/gif') {
                $image = imagecreatefromgif($file);
            } elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($file);
            }
            unlink($file);
            $files[] = $image;
        }
        
        
        $newOrder = explode(",",$data['ids']);
        $counter = 1;
        $path = $basePath.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'offer'.DIRECTORY_SEPARATOR.$offer->getSlug();
        foreach($newOrder as $item){
            imagejpeg($files[trim($item)], $path.DIRECTORY_SEPARATOR.$counter.'.jpg', 75);
            $counter++;
        }
        $result['result'] = true;

        return $this->json($result);
    }

    public function removeAction($id) {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = $offerManager->find($id); /* @var $offer Offer */
        $session = $this->get('session');

        if (!$offer) {
            $session->getFlashBag()->add('danger', 'Nie znaleziono oferty.');
        } else {
            $mailManager = $this->get(MailManager::SERVICE); /* @var $mailManager MailManager */
            $mails = $mailManager->findByOffer($offer); /* @var $mails Mail[] */
            foreach ($mails as $mail) {
                $mail->setOffer(null);
                $mailManager->update($mail);
            }
            $offerManager->remove($offer);
            $session->getFlashBag()->add('success', 'Pomyślnie usunięto ofertę.');
        }

        return $this->redirect($this->generateUrl('user_offer'));
    }

}
