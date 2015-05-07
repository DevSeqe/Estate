<?php

namespace Bit2Bit\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ElementsController extends Controller
{   
    
    public function menuAction(){
        $menu = array(
            array(
                'route' => 'panel_dashboard',
                'name' => 'Pulpit',
                'icon' => 'fa fa-dashboard'
            ),
            array(
                'route' => 'panel_users',
                'name' => 'Użytkownicy',
                'icon' => 'fa fa-group'
            ),
        );
        return $this->render('MainBundle:Elements:menu.html.twig', array('menu'=>$menu));        
    }
   
}
