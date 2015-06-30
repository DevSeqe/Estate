<?php

namespace Bit2Bit\OfferBundle\Model;

use Bit2Bit\BaseBundle\Entity\AbstractEntity;

class Offer extends AbstractEntity {

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
    protected $published;
    protected $rent;
    protected $video;
    protected $marketType;
    protected $created;
    protected $commition;
    protected $similar;
    protected $water;
    protected $gas;
    protected $sewerage;
    protected $views;
    protected $totalViews;

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

    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setLocalization($localization) {
        $this->localization = $localization;
        return $this;
    }

    public function getLocalization() {
        return $this->localization;
    }

    public function setPricePerMeter($pricePerMeter) {
        $this->pricePerMeter = $pricePerMeter;
        return $this;
    }

    public function getPricePerMeter() {
        return $this->pricePerMeter;
    }

    public function setArea($area) {
        $this->area = $area;
        return $this;
    }

    public function getArea() {
        return $this->area;
    }

    public function setRooms($rooms) {
        $this->rooms = $rooms;
        return $this;
    }

    public function getRooms() {
        return $this->rooms;
    }

    public function setFloor($floor) {
        $this->floor = $floor;
        return $this;
    }

    public function getFloor() {
        return $this->floor;
    }

    public function setNumberOfFloors($numberOfFloors) {
        $this->numberOfFloors = $numberOfFloors;
        return $this;
    }

    public function getNumberOfFloors() {
        return $this->numberOfFloors;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getType($key = true) {
        if ($key) {
            return $this->type;
        } else {
            $types = \Bit2Bit\OfferBundle\Enum\Type::getList();
            return (isset($types[$this->type])) ? $types[$this->type] : '';
        }
    }

    public function setAvailableFrom($availableFrom) {
        $this->availableFrom = $availableFrom;
        return $this;
    }

    public function getAvailableFrom() {
        return $this->availableFrom;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDetails($details) {
        $this->details = $details;
        return $this;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setAgent($agent) {
        $this->agent = $agent;
        return $this;
    }

    public function getAgent() {
        return $this->agent;
    }

    public function setHotOffer($hotOffer) {
        $this->hotOffer = $hotOffer;
        return $this;
    }

    public function getHotOffer() {
        return $this->hotOffer;
    }

    public function setDiscount($discount) {
        $this->discount = $discount;
        return $this;
    }

    public function getDiscount() {
        return $this->discount;
    }

    function getPublished() {
        return $this->published;
    }

    function setPublished($published) {
        $this->published = $published;
        return $this;
    }

    function getRent() {
        return $this->rent;
    }

    function setRent($rent) {
        $this->rent = $rent;
        return $this;
    }

    function getVideo() {
        return $this->video;
    }

    function setVideo($video) {
        $this->video = $video;
        return $this;
    }

    function getMarketType() {
        return $this->marketType;
    }

    function setMarketType($marketType) {
        $this->marketType = $marketType;
        return $this;
    }

    function getCreated() {
        return $this->created;
    }

    function setCreated($created) {
        $this->created = $created;
        return $this;
    }

    function getCommition() {
        return $this->commition;
    }

    function setCommition($commition) {
        $this->commition = $commition;
        return $this;
    }

    function getSimilar() {
        return $this->similar;
    }

    function setSimilar($similar) {
        $this->similar = $similar;
        return $this;
    }

    function getWater() {
        if ($this->water == "")
            $this->water = "yes";
        return $this->water;
    }

    function getGas() {
        if ($this->gas == "")
            $this->gas = "yes";
        return $this->gas;
    }

    function getSewerage() {
        if ($this->sewerage == "")
            $this->sewerage = "yes";
        return $this->sewerage;
    }

    function setWater($water) {
        $this->water = $water;
        return $this;
    }

    function setGas($gas) {
        $this->gas = $gas;
        return $this;
    }

    function setSewerage($sewerage) {
        $this->sewerage = $sewerage;
        return $this;
    }
    
    function getViews() {
        return $this->views;
    }

    function getTotalViews() {
        return $this->totalViews;
    }

    function setViews($views) {
        $this->views = $views;
        return $this;
    }

    function setTotalViews($totalViews) {
        $this->totalViews = $totalViews;
        return $this;
    }



}
