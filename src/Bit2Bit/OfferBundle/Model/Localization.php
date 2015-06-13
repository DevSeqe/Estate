<?php

namespace Bit2Bit\OfferBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Localization extends AbstractEntity{

	protected $id;
	protected $city;
	protected $street;
	protected $building;
	protected $latitude;
	protected $longitude;


	public function getId(){
		return $this->id;
	}

	public function setCity($city){
		$this->city = $city;
		return $this;
	}

	public function getCity(){
		return $this->city;
	}

	public function setStreet($street){
		$this->street = $street;
		return $this;
	}

	public function getStreet(){
		return $this->street;
	}

	public function setBuilding($building){
		$this->building = $building;
		return $this;
	}

	public function getBuilding(){
		return $this->building;
	}

	public function setLatitude($latitude){
		$this->latitude = $latitude;
		return $this;
	}

	public function getLatitude(){
		return $this->latitude;
	}

	public function setLongitude($longitude){
		$this->longitude = $longitude;
		return $this;
	}

	public function getLongitude(){
		return $this->longitude;
	}


}