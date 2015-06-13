<?php

namespace Bit2Bit\MainBundle\Controller;

use Bit2Bit\MainBundle\Base\MenuGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ElementsController extends Controller
{   
    
    public function menuAction(){
        $user = $this->get('security.context')->getToken()->getUser();
        $menuGenerator = new MenuGenerator($user);
        
        $menuGenerator->add('Pulpit', 'panel_dashboard', 'fa fa-dashboard')
                ->add('Użytkownicy', 'panel_users', 'fa fa-group')
                ->add('Oferty', 'user_localization', 'fa fa-home')
                ->add('Lokalizacje', 'user_localization', 'fa fa-map-marker')
                ->add('Subskrybenci', 'admin_subscriber', 'fa fa-at', 'ROLE_ADMIN')
                ->add('Newsletter', 'admin_message', 'fa fa-envelope', 'ROLE_ADMIN')
                ->add('Ustawienia', 'admin_settings', 'fa fa-cogs', 'ROLE_ADMIN');
        
        
        return $this->render('MainBundle:Elements:menu.html.twig', array('menu'=>$menuGenerator->getMenu()));        
    }
   
}
