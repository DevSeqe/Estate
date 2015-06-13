<?php

namespace Bit2Bit\OfferBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Offer extends AbstractEntity{

	protected $id;
	protected $name;
	protected $slug;
	protected $localization;
	protected $pricePerMeter;
	protected $area;
	protected $rooms;
	protected $floor;
	protected $numberOfFloors;
	protected $type;
	protected $availableFrom;
	protected $description;
	protected $details;
	protected $agent;
	protected $hotOffer;
	protected $discount;


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

	public function setLocalization($localization){
		$this->localization = $localization;
		return $this;
	}

	public function getLocalization(){
		return $this->localization;
	}

	public function setPricePerMeter($pricePerMeter){
		$this->pricePerMeter = $pricePerMeter;
		return $this;
	}

	public function getPricePerMeter(){
		return $this->pricePerMeter;
	}

	public function setArea($area){
		$this->area = $area;
		return $this;
	}

	public function getArea(){
		return $this->area;
	}

	public function setRooms($rooms){
		$this->rooms = $rooms;
		return $this;
	}

	public function getRooms(){
		return $this->rooms;
	}

	public function setFloor($floor){
		$this->floor = $floor;
		return $this;
	}

	public function getFloor(){
		return $this->floor;
	}

	public function setNumberOfFloors($numberOfFloors){
		$this->numberOfFloors = $numberOfFloors;
		return $this;
	}

	public function getNumberOfFloors(){
		return $this->numberOfFloors;
	}

	public function setType($type){
		$this->type = $type;
		return $this;
	}

	public function getType(){
		return $this->type;
	}

	public function setAvailableFrom($availableFrom){
		$this->availableFrom = $availableFrom;
		return $this;
	}

	public function getAvailableFrom(){
		return $this->availableFrom;
	}

	public function setDescription($description){
		$this->description = $description;
		return $this;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDetails($details){
		$this->details = $details;
		return $this;
	}

	public function getDetails(){
		return $this->details;
	}

	public function setAgent($agent){
		$this->agent = $agent;
		return $this;
	}

	public function getAgent(){
		return $this->agent;
	}

	public function setHotOffer($hotOffer){
		$this->hotOffer = $hotOffer;
		return $this;
	}

	public function getHotOffer(){
		return $this->hotOffer;
	}

	public function setDiscount($discount){
		$this->discount = $discount;
		return $this;
	}

	public function getDiscount(){
		return $this->discount;
	}


}