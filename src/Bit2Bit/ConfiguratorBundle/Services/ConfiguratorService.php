<?php

namespace Bit2Bit\ConfiguratorBundle\Services;

use Doctrine\ORM\EntityManager;

/**
 * Description of ManagerService
 *
 * @author Paweł
 */
class ConfiguratorService {
    //put your code here
    
    protected $em;
    protected $class;
    protected $repository;
    protected $dbal;
    protected $table;
    
    public function __construct($entityManager){
        $this->em = $entityManager;
    }
    
    public function get($key){
        $setting = $this->em->getRepository('ConfiguratorBundle:Setting')->findOneByKey($key);
        if(!$setting){
            return '';
        }
        return $setting->getValue();
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
