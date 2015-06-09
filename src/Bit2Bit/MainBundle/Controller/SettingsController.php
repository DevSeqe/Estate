<?php

namespace Bit2Bit\MainBundle\Controller;

use Bit2Bit\ConfiguratorBundle\Entity\Setting;
use Bit2Bit\ConfiguratorBundle\Manager\SettingManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller {

    public function indexAction() {

        $settingManager = $this->get(SettingManager::SERVICE); /* @var $settingManager SettingManager */
        $settings = $settingManager->findBy(array(), array('key' => 'ASC')); /* @var $setting Setting */

        return $this->render('MainBundle:Settings:index.html.twig', array('settings' => $settings));
    }

    public function changeAction(Request $request) {

        $data = $request->request->all();
        
        $session = $this->get('session');
        if (isset($data['set_id']) && isset($data['set_value'])) {
            $settingManager = $this->get(SettingManager::SERVICE); /* @var $settingManager SettingManager */
            $setting = $settingManager->find($data['set_id']); /* @var $setting Setting */
            if(!$setting){
                $session->getFlashBag()->add('danger','Nie odnaleziono ustawienia.');                                        
            }
            else{
                $setting->setValue($data['set_value']);
                $settingManager->update($setting);
                $session->getFlashBag()->add('success','Pomyślnie zmieniono ustawienie.');                                        
            }
        }
        else{
            $session->getFlashBag()->add('danger','Odebrano nieprawidłowe żądanie.');                        
        }
        return $this->redirect($this->generateUrl('admin_settings'));
    }

}
