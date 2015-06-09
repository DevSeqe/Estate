<?php

namespace Bit2Bit\NewsletterBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Message extends AbstractEntity{

	protected $id;
	protected $name;
	protected $content;


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

	public function setContent($content){
		$this->content = $content;
		return $this;
	}

	public function getContent(){
		return $this->content;
	}


}