<?php

namespace Bit2Bit\OfferBundle\Entity;

use Bit2Bit\OfferBundle\Model\Localization as Base;

class Localization extends Base {

    const EN = 'OfferBundle:Localization';
    const ENN = 'Bit2Bit\OfferBundle\Entity\Localization';

    public function __toString() {
        return $this->getCity().(($this->getStreet() != '') ? ', ul. '.$this->getStreet() : '').' '.$this->getBuilding();
    }
}
