<?php

namespace EatFit\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ElementsController extends Controller
{
    public function mailsAction()
    {
        $mails = array(
            array(
                'from' => 'Tester',
                'content' => 'Testowa wiadomość',
                'time' => '09:58',
                'read' => false
            ),
        );
        return $this->render('MainBundle:Elements:mails.html.twig', array('mails'=>$mails));
    }
    
    public function notificationsAction(){
        $notifications = array(
            array(
                'text' => 'Jakieś wydarzenie',
                'icon' => 'fa fa-user',
                'color' => 'text-aqua',
                'url' => '#'
            ),
        );
        return $this->render('MainBundle:Elements:notifications.html.twig', array('notifications'=>$notifications));        
    }
    
    public function menuAction(){
        $menu = array(
            array(
                'route' => 'panel_dashboard',
                'name' => 'Pulpit',
                'icon' => 'fa fa-dashboard'
            ),
        );
        return $this->render('MainBundle:Elements:menu.html.twig', array('menu'=>$menu));        
    }
}
