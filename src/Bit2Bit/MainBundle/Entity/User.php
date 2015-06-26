<?php

namespace Bit2Bit\MainBundle\Entity;

use Bit2Bit\MainBundle\Model\User as Base;

class User extends Base{

	const EN = 'MainBundle:User';
	const ENN = 'Bit2Bit\MainBundle\Entity\User';
        
        public function hasRole($role){
            $roles = $this->getRoles();
            foreach($roles as $tRole){
                if($tRole == $role){
                    return true;
                }
            }
            return false;
        }
        
        public function __toString() {
            parent::__toString();
            return ($this->getName() != '' && $this->getSurname() != '') ? $this->getName().' '.$this->getSurname() : $this->getUsername();
        }

}