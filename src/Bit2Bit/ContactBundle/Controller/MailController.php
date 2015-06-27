<?php

namespace Bit2Bit\ContactBundle\Controller;

use Bit2Bit\ContactBundle\Entity\Mail;
use Bit2Bit\ContactBundle\Manager\MailManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailController extends Controller
{
    const NAME = 'ContactBundle:Mail';
    
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $mailManager = $this->get(MailManager::SERVICE); /* @var $mailManager MailManager */
        $mails = $mailManager->findUserMails($user); /* @var $mails Mail[] */
        return $this->render(self::NAME.':index.html.twig', array('mails' => $mails));
    }
    
    public function readAction($id)
    {
        $mailManager = $this->get(MailManager::SERVICE); /* @var $mailManager MailManager */
        $mail = $mailManager->find($id); /* @var $mail Mail */
        
        if(!$mail){
            $session = $this->get('session');
            $session->getFlashBag()->add('danger','Nie znaleziono wiadomości.');
            return $this->redirect($this->generateUrl('user_mail'));
        }
        
        if(!$mail->getReaded()){
            if($mail->getMailGroup() != null){
                $otherMails = $mailManager->getMailGroup($mail->getMailGroup());
                foreach($otherMails as $oMail){
                    $oMail->setReaded(true);
                    $mailManager->update($oMail);     
                }
            }
            else{
                $mail->setReaded(true);
            }
            $mailManager->update($mail);
        }
        
        return $this->render(self::NAME.':read.html.twig', array('mail' => $mail));
    }
}
