<?php

namespace Bit2Bit\MainBundle\Controller;

use Bit2Bit\MainBundle\Entity\User;
use Bit2Bit\MainBundle\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    
    const NAME = 'MainBundle:Users';
    
    public function indexAction()
    {
        $curUser = $this->get('security.context')->getToken()->getUser();       
               
        $userManager = $this->get(UserManager::SERVICE); /* @var $userManager UserManager */
        $users = $userManager->findAll(); /* @var $users User[] */
        
        return $this->render(self::NAME.':index.html.twig', array('users'=>$users,'isAdmin'=>$curUser->hasRole('ROLE_ADMIN')));
    }
        
}
