<?php

namespace Bit2Bit\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();  
        
        return $this->render('MainBundle:Dashboard:index.html.twig');
    }
        
}
