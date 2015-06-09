<?php

namespace Bit2Bit\MainBundle\Controller;

use Bit2Bit\MainBundle\Base\AbstractController;
use Bit2Bit\MainBundle\Entity\User;
use Bit2Bit\MainBundle\Form\ActivateAccountType;
use Bit2Bit\MainBundle\Form\NewUserType;
use Bit2Bit\MainBundle\Manager\UserManager;
use DateTime;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends AbstractController {

    const NAME = 'MainBundle:Users';

    /**
     * Method to list all of users registered in system.
     * 
     * @return view
     */
    public function indexAction() {
        $curUser = $this->get('security.context')->getToken()->getUser();

        $userManager = $this->get(UserManager::SERVICE); /* @var $userManager UserManager */
        $users = $userManager->findAll(); /* @var $users User[] */

        return $this->render(self::NAME . ':index.html.twig', array('users' => $users, 'isAdmin' => $curUser->hasRole('ROLE_ADMIN')));
    }

    /**
     * Method creates form to add new user.
     * 
     * @return view
     */
    public function newAction() {

        $user = new User();

        $form = $this->createForm(new NewUserType(), $user, array(
            'action' => $this->generateUrl('admin_user_create'),
            'method' => 'POST',
        ));

        return $this->render(self::NAME . ':new.html.twig', array('form' => $form->createView()));
    }

    public function createAction(Request $request) {
        $user = new User();

        $form = $this->createForm(new NewUserType(), $user, array(
            'action' => $this->generateUrl('admin_user_create'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager = $this->get(UserManager::SERVICE); /* @var $userManager UserManager */
            $session = $this->get('session');
            $date = new DateTime('NOW');
            $user->setUsername('user' . $date->getTimestamp())
                    ->addRole('ROLE_USER')
                    ->setRegisterKey(md5($date->getTimestamp()))
                    ->setPassword('none');
            $userManager->persist($user)
                    ->flush();
            $session->getFlashBag()->add('success', 'Pomyślnie dodano użytkownika.');
            
            $mail = json_decode($this->sendActivationMailAction($user->getId())->getContent(),true);
            if($mail['success']){
                $session->getFlashBag()->add('success', 'Wysłano email do aktywacji konta.');                
            }
            else{
                $session->getFlashBag()->add('danger', 'Wystąpił błąd podczas wysyłania maila do aktywacji konta. Upewnij się, że wporwadzono prawidłowy adres email, lub spróbuj ponownie później.');                                
            }            
            
            return $this->redirect($this->generateUrl('panel_users'));
        }
        return $this->render(self::NAME . ':new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function sendActivationMailAction($id) {
        $userManager = $this->get(UserManager::SERVICE); /* @var $userManager UserManager */
        $user = $userManager->find($id); /* @var $user User */
       
        if (!$user) {
            return $this->json(array('success'=>false,'msg' => 'Nie znaleziono użytkownika.'));
        }

        if ($user->getIsActive()) {
            return $this->json(array('success'=>false,'msg' => 'Ten użytkownik jest już aktywny.'));
        }

        $message = Swift_Message::newInstance()
                ->setSubject('Konifugracja konta w systemie')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($user->getEmail())
                ->setBody(
                $this->renderView('Emails/registration.html.twig', array('user'=>$user)), 'text/html'
        );
        $this->get('mailer')->send($message);
        return $this->json(array('success'=>true,'msg' => 'Wysłano email do aktywacji konta.'));
    }
    
    public function removeAction($id) {
        $userManager = $this->get(UserManager::SERVICE); /* @var $userManager UserManager */
        $user = $userManager->find($id); /* @var $user User */

        $session = $this->get('session');
            
        if (!$user) {
            $session->getFlashBag()->add('danger', 'Nie znaleziono użytkownika.');            
        }
        else{
            $userManager->remove($user);
            $session->getFlashBag()->add('success', 'Pomyślnie usunięto użytkownika.');                        
        }
        
        return $this->redirect($this->generateUrl('panel_users'));
    }
    
    public function activateAccountAction(Request $request, $key){
        $userManager = $this->get(UserManager::SERVICE); /* @var $userManager UserManager */
        $user = $userManager->findOneByRegisterKey($key); /* @var $user User */
        if(!$user){
            return $this->redirect($this->generateUrl('front_homepage'));
        }
        
        $form = $this->createForm(new ActivateAccountType(), $user, array(
            'action' => $this->generateUrl('activate_account',array('key'=>$key)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {            
            $session = $this->get('session');  
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $encodedPass = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setIsActive(true)
                    ->setEnabled(true)
                    ->setPassword($encodedPass);
            $userManager->update($user);
            $session->getFlashBag()->add('success', 'Pomyślnie aktywowano konto, możesz się teraz zalogować.');
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        return $this->render(self::NAME . ':activate.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
