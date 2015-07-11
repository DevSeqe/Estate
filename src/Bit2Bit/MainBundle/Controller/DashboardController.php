<?php

namespace Bit2Bit\MainBundle\Controller;

use Bit2Bit\ContactBundle\Entity\Mail;
use Bit2Bit\ContactBundle\Manager\MailManager;
use Bit2Bit\NewsletterBundle\Entity\Subscriber;
use Bit2Bit\NewsletterBundle\Manager\SubscriberManager;
use Bit2Bit\OfferBundle\Entity\Offer;
use Bit2Bit\OfferBundle\Manager\OfferManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller {

    public function indexAction() {
        $user = $this->get('security.context')->getToken()->getUser();

        //widget "Zgłosozne oferty"
        $mailManager = $this->get(MailManager::SERVICE); /* @var $mailManager MailManager */
        $reports = $mailManager->findLatestReports($user); /* @var $reports Mail[] */

        //widget ostatnie wiaodmości
        $mails = $mailManager->findLatestMails($user); /* @var $reports Mail[] */

        //widget liczba wyświetleń
        $offerManager = $this->get(OfferManager::SERVICE); /* @var $offerManager OfferManager */
        $offers = $offerManager->findMostViewed(); /* @var $offers Offer[] */

        $subscriberManager = $this->get(SubscriberManager::SERVICE); /* @var $subscriberManager SubscriberManager */
        $subscribers = $subscriberManager->findNewest(); /* @var $subscribers Subscriber[] */

        return $this->render('MainBundle:Dashboard:index.html.twig', array(
                    'reports' => $reports,
                    'mails' => $mails,
                    'subscribers' => $subscribers,
                    'offers' => $offers
        ));
    }

}
