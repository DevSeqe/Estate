<?php

namespace Bit2Bit\CmsBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Page extends AbstractEntity{

	protected $id;
	protected $name;
	protected $slug;
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

	public function setSlug($slug){
		$this->slug = $slug;
		return $this;
	}

	public function getSlug(){
		return $this->slug;
	}

	public function setContent($content){
		$this->content = $content;
		return $this;
	}

	public function getContent(){
		return $this->content;
	}


}