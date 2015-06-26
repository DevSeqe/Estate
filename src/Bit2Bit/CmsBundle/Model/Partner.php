<?php

namespace Bit2Bit\CmsBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Partner extends AbstractEntity{

	protected $id;
	protected $name;
	protected $url;
	protected $image;


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

	public function setUrl($url){
		$this->url = $url;
		return $this;
	}

	public function getUrl(){
		return $this->url;
	}

	public function setImage($image){
		$this->image = $image;
		return $this;
	}

	public function getImage(){
		return $this->image;
	}


}