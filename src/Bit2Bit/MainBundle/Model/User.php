<?php

namespace Bit2Bit\MainBundle\Model;

use FOS\UserBundle\Model\User as Base;

class User extends Base {

    public function __construct() {
        parent::__construct();
        
        $this->isActive = false;
    }

    protected $id;
    protected $name;
    protected $surname;
    protected $isActive;

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
        return $this;
    }

    public function getSurname() {
        return $this->surname;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

}
