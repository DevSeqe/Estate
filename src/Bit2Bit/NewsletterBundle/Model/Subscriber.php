<?php

namespace Bit2Bit\NewsletterBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Subscriber extends AbstractEntity{

	protected $id;
	protected $name;
	protected $email;
	protected $active;


	public function getId(){
		return $this->id;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function getName(){
		return $this->name;
	}

	public function setEmail($email){
		$this->email = $email;
		return $this;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setActive($active){
		$this->active = $active;
		return $this;
	}

	public function getActive(){
		return $this->active;
	}


}