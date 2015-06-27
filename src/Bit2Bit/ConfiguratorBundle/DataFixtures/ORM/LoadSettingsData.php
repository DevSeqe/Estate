<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoadAppData
 *
 * @author Paweł
 */
namespace Bit2Bit\ConfiguratorBundle\DataFixtures\ORM;

use Bit2Bit\ConfiguratorBundle\Entity\Setting;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Generuje podstawową firmę, po której będą dziedziczone globalne ustawienia firm.
 */
class LoadSettingsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $setting = new Setting(); /* @var $setting Setting */
        $setting->setKey('base')
                ->setName('Ustawienia podstawowe')
                ->setDescription('Sekcja zawiera podstawowe ustawienia dotyczące aplikacji.');
        
        $settingName = new Setting();
        $settingName->setKey('base:name')
                ->setName('Nazwa aplikacji');
        
        $settingPhone = new Setting();
        $settingPhone->setKey('base:phone')
                ->setName('Numer telefonu');
        
        $settingSocial = new Setting();
        $settingSocial->setKey('social')
                ->setName('Ustawienia mediów społecznościowych.')
                ->setDescription('W tej sekcji znajdują się ustawienia mediów społecznościowych.');
        
        $settingFacebook = new Setting();
        $settingFacebook->setKey('social:facebook')
                ->setName('Facebook');
        
        $settingGplus = new Setting();
        $settingGplus->setKey('social:gplus')
                ->setName('Google Plus');
        
        $settingTwitter = new Setting();
        $settingTwitter->setKey('social:twitter')
                ->setName('Twitter');
        
        
        $manager->persist($setting);
        $manager->persist($settingName);
        $manager->persist($settingPhone);
        $manager->persist($settingSocial);
        $manager->persist($settingFacebook);
        $manager->persist($settingGplus);
        $manager->persist($settingTwitter);
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 1; 
    }
}
