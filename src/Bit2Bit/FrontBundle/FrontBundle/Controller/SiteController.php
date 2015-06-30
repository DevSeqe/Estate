<?php

namespace Bit2Bit\FrontBundle\FrontBundle\Controller;

use Bit2Bit\CmsBundle\Entity\Page;
use Bit2Bit\CmsBundle\Entity\Partner;
use Bit2Bit\CmsBundle\Manager\PageManager;
use Bit2Bit\CmsBundle\Manager\PartnerManager;
use Bit2Bit\ContactBundle\Entity\Mail;
use Bit2Bit\ContactBundle\Enum\MailCategory;
use Bit2Bit\ContactBundle\Form\ContactAgentType;
use Bit2Bit\ContactBundle\Form\ContactType;
use Bit2Bit\ContactBundle\Manager\MailManager;
use Bit2Bit\MainBundle\Entity\User;
use Bit2Bit\MainBundle\Manager\UserManager;
use Bit2Bit\OfferBundle\Entity\Offer;
use Bit2Bit\OfferBundle\Manager\OfferManager;
use DateTime;
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
        $offer->addView();
        $offerManager->update($offer);
        return $this->render('FrontBundle:Site:offer.html.twig', array('offer' => $offer));
    }

    public function printOfferAction($id) {
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = $offerManager->find($id); /* @var $offer Offer */

        if (!$offer) {
            return $this->createNotFoundException('Nie znaleźliśmy oferty z takim identyfikatorem! ;(');
        }

        if (!$offer->getPublished()) {
            return $this->createNotFoundException('Nie znaleźliśmy oferty z takim identyfikatorem! ;(');
        }
        return $this->render('FrontBundle:Site:print.html.twig', array('offer' => $offer));
    }

    public function advicePageAction() {
        return $this->render('FrontBundle:Site:advice.html.twig');
    }

    public function aboutAction() {
        $pageManager = $this->get(PageManager::SERVICE); /* @var $pageManager PageManager */
        $page = $pageManager->findOneBySlug('o-nas'); /* @var $page Page */
        
        $catalog = getcwd() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'diplomas';
        $diplomas = array();
        if ($handle = opendir($catalog)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (!is_dir($catalog . DIRECTORY_SEPARATOR . $entry)) {
                        $diplomas[] = '/images/diplomas' . DIRECTORY_SEPARATOR . $entry;
                    }
                }
            }
            closedir($handle);
        }

        if (!$page) {
            $page = "";
        } else {
            $page = $page->getContent();
        }
        return $this->render('FrontBundle:Site:about.html.twig',array('page'=>$page,'diplomas'=>$diplomas));
    }
    
    public function creditsAction() {
        $pageManager = $this->get(PageManager::SERVICE); /* @var $pageManager PageManager */
        $page = $pageManager->findOneBySlug('kredyty'); /* @var $page Page */

        if (!$page) {
            $page = "";
        } else {
            $page = $page->getContent();
        }
        return $this->render('FrontBundle:Site:credits.html.twig',array('page'=>$page));
    }

    public function contactAction(Request $request, $type) {

        $alternatives = array(MailCategory::BUY, MailCategory::OFFER, MailCategory::REPORT, MailCategory::SEARCH);

        $mailManager = $this->get(MailManager::SERVICE); /* @var $mailManager MailManager */
        $mail = new Mail();

        if (in_array($type, $alternatives)) {
            $cats = MailCategory::getList();
            $mail->setTitle($cats[$type]);
            $mail->setCategory($type);
        }

        $form = $this->createForm(new ContactType(), $mail, array(
            'action' => $this->generateUrl('contact'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $cats = MailCategory::getList();
            $now = new DateTime('now');
            $group = (string) $now->getTimestamp();
            $mail->setCreated($now)
                    ->setMailGroup($group)
                    ->setTitle($cats[$mail->getCategory()])
                    ->setReaded(false);

            $userManager = $this->get(UserManager::SERVICE); /* @var $userManager UserManager */
            $users = $userManager->findAll(); /* @var $users User[] */

            foreach ($users as $user) {
                $toSend = clone $mail;
                $toSend->setOwner($user);
                $mailManager->persist($toSend);
            }

            $session = $this->get('session');
            $mailManager->flush();
            $session->getFlashBag()->add('success', 'Twoja wiadomość została wysłana.');
            return $this->redirect($this->generateUrl('contact'));
        }

        $pageManager = $this->get(PageManager::SERVICE); /* @var $pageManager PageManager */
        $page = $pageManager->findOneBySlug('kontakt'); /* @var $page Page */

        if (!$page) {
            $page = "";
        } else {
            $page = $page->getContent();
        }

        return $this->render('FrontBundle:Site:contact.html.twig', array(
                    'form' => $form->createView(),
                    'page' => $page
        ));
    }

    public function contactAgentAction(Request $request, $id) {

        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offer = $offerManager->find($id); /* @var $offer Offer */


        $user = $offer->getAgent(); /* @var $user User */

        $session = $this->get('session');

        if (!$offer) {
            return $this->redirect($this->generateUrl('contact'));
        }

        $mailManager = $this->get(MailManager::SERVICE); /* @var $mailManager MailManager */
        $mail = new Mail();

        $mail->setTitle('Kontakt w sprawie oferty.');

        $form = $this->createForm(new ContactAgentType(), $mail, array(
            'action' => $this->generateUrl('contact_agent', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $now = new DateTime('now');
            $mail->setCreated($now)
                    ->setOwner($user)
                    ->setReaded(false)
                    ->setOffer($offer);

            $mailManager->persist($mail);

            $mailManager->flush();
            $session->getFlashBag()->add('success', 'Twoja wiadomość została wysłana.');
            return $this->redirect($this->generateUrl('contact_agent', array('id' => $id)));
        }

        $pageManager = $this->get(PageManager::SERVICE); /* @var $pageManager PageManager */
        $page = $pageManager->findOneBySlug('kontakt'); /* @var $page Page */

        if (!$page) {
            $page = "";
        } else {
            $page = $page->getContent();
        }


        return $this->render('FrontBundle:Site:contact.html.twig', array(
                    'form' => $form->createView(),
                    'page' => $page
        ));
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
