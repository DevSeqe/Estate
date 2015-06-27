<?php

namespace Bit2Bit\ContactBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Mail extends AbstractEntity{

	protected $id;
	protected $title;
	protected $content;
	protected $category;
	protected $mailGroup;
	protected $readed;
	protected $email;
	protected $name;
	protected $phone;
	protected $owner;
	protected $offer;
	protected $created;


	public function getId(){
		return $this->id;
	}

	public function setTitle($title){
		$this->title = $title;
		return $this;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setContent($content){
		$this->content = $content;
		return $this;
	}

	public function getContent(){
		return $this->content;
	}

	public function setCategory($category){
		$this->category = $category;
		return $this;
	}

	public function getCategory(){
		return $this->category;
	}

	public function setMailGroup($group){
		$this->mailGroup = $group;
		return $this;
	}

	public function getMailGroup(){
		return $this->mailGroup;
	}

	public function setReaded($read){
		$this->readed = $read;
		return $this;
	}

	public function getReaded(){
		return $this->readed;
	}

	public function setEmail($email){
		$this->email = $email;
		return $this;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function getName(){
		return $this->name;
	}

	public function setPhone($phone){
		$this->phone = $phone;
		return $this;
	}

	public function getPhone(){
		return $this->phone;
	}

	public function setOwner($owner){
		$this->owner = $owner;
		return $this;
	}

	public function getOwner(){
		return $this->owner;
	}
        
        function getOffer() {
            return $this->offer;
        }

        function getCreated() {
            return $this->created;
        }

        function setOffer($offer) {
            $this->offer = $offer;
            return $this;
        }

        function setCreated($created) {
            $this->created = $created;
            return $this;
        }




}