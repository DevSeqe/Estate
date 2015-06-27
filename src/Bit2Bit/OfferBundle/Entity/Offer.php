<?php

namespace Bit2Bit\OfferBundle\Entity;

use Bit2Bit\OfferBundle\Model\Offer as Base;

class Offer extends Base {

    const EN = 'OfferBundle:Offer';
    const ENN = 'Bit2Bit\OfferBundle\Entity\Offer';

    private $photos = array();
    private $videoCode;

    public function getPrice($discount = true) {
        if ($discount) {
            return round(($this->pricePerMeter * $this->area) - $this->discount, 2);
        } else {
            return round(($this->pricePerMeter * $this->area), 2);
        }
    }

    public function getPhotos() {
        if(!empty($this->photos)){
            return $this->photos;
        }
        $catalog = getcwd() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'offer' . DIRECTORY_SEPARATOR . $this->getSlug();
        if ($handle = opendir($catalog)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (!is_dir($catalog . DIRECTORY_SEPARATOR . $entry)) {
                        $this->photos[] = '/images/offer' . DIRECTORY_SEPARATOR . $this->getSlug() . DIRECTORY_SEPARATOR . $entry;
                    }
                }
            }
            closedir($handle);
        }
        sort($this->photos);
        return $this->photos;
    }

    public function hasPhotos(){
        $photos = $this->getPhotos();
        $has = !empty($photos);
        return $has;
    }
    
    public function getThumbnail() {
        if(!$this->hasPhotos()){
            return $this->photos[0];
        }    
        return '/images/nophoto.jpg';
    }
        
    public function getVideoCode(){        
        $parts = explode("?v=", $this->getVideo());
        
        if(!isset($parts[1])){
            return '';
        }
        $this->videoCode = $parts[1];
        return $this->videoCode;
    }
    

}
