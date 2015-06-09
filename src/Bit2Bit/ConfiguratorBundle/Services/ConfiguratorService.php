<?php

namespace Bit2Bit\ConfiguratorBundle\Services;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Description of ManagerService
 *
 * @author Paweł
 */
class ConfiguratorService {

    //put your code here

    protected $em;
    protected $container;
    protected $setFile;
    protected $class;
    protected $repository;
    protected $dbal;
    protected $table;

    public function __construct($entityManager, $container) {
        $this->em = $entityManager;
        $this->container = $container;

        $this->setFile = $this->container->getParameter('kernel.cache_dir') . '/b2b/settings';
        if (!file_exists($this->setFile)) {
            $fs = new Filesystem();
            try {
                $fs->mkdir(dirname($this->setFile));
                $settings = $this->em->getRepository('ConfiguratorBundle:Setting')->findAll();
                $settingsCache = '';
                foreach($settings as $setting){
                    $settingsCache .= $setting->getKey().'|<=>|'.$setting->getValue().PHP_EOL;
                }
                file_put_contents($this->setFile, $settingsCache);
            } catch (IOException $e) {
                echo "Error occured while cacheing settings";
            }
        }
    }
    
    private function getCache(){
        $settingsCache = file_get_contents($this->setFile);        
                
        $settingsLines = explode(PHP_EOL, $settingsCache);
        $settings = array();
        foreach($settingsLines as $line){
            $keyValue = explode('|<=>|',$line);
            $settings[$keyValue[0]] = (isset($keyValue[1])) ? $keyValue[1] : '';
        }
        return $settings;
    }

    public function get($key) {
        $settings = $this->getCache();        
        if (!isset($settings[$key])) {
            return '';
        }
        return $settings[$key];
    }

    public function getEm() {
        return $this->em;
    }

    public function setEm($em) {
        $this->em = $em;
        return $this;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getDbal() {
        return $this->dbal;
    }

    public function getTable() {
        return $this->table;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
        return $this;
    }

    public function setDbal($dbal) {
        $this->dbal = $dbal;
        return $this;
    }

    public function setTable($table) {
        $this->table = $table;
        return $this;
    }

}
