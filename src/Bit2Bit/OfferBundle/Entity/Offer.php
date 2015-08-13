<?php

namespace Bit2Bit\OfferBundle\Entity;

use Bit2Bit\OfferBundle\Model\Offer as Base;
use DateInterval;
use DateTime;

class Offer extends Base {

    const EN = 'OfferBundle:Offer';
    const ENN = 'Bit2Bit\OfferBundle\Entity\Offer';

    private $photos = array();
    private $plan = null;
    private $videoCode;
    private $diff = null;

    public function getPrice($discount = true) {
        if ($discount) {
            return $this->totalPrice - $this->discount;
        }

        return $this->totalPrice;
    }

    public function getPhotos() {
        if (!empty($this->photos)) {
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

    public function getPlan() {
        if (!empty($this->plan)) {
            return $this->plan;
        }
        $catalog = getcwd() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'offer' . DIRECTORY_SEPARATOR . $this->getSlug() . DIRECTORY_SEPARATOR . 'plan';
        if (file_exists($catalog)) {
            if ($handle = opendir($catalog)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        if (!is_dir($catalog . DIRECTORY_SEPARATOR . $entry)) {
                            $this->plan = '/images/offer' . DIRECTORY_SEPARATOR . $this->getSlug() . DIRECTORY_SEPARATOR . 'plan' . DIRECTORY_SEPARATOR . $entry;
                            break;
                        }
                    }
                }
                closedir($handle);
            }
        }
        return $this->plan;
    }

    public function hasPhotos() {
        $photos = $this->getPhotos();
        $has = !empty($photos);
        return $has;
    }

    public function getThumbnail() {
        if ($this->hasPhotos()) {
            return $this->photos[0];
        }
        return '/images/nophoto.jpg';
    }

    public function getVideoCode() {
        $parts = explode("?v=", $this->getVideo());

        if (!isset($parts[1])) {
            return '';
        }
        $this->videoCode = $parts[1];
        return $this->videoCode;
    }

    public function addView() {
        $this->totalViews++;
        $now = new DateTime('NOW');
        if (!isset($this->views[$now->format('Y-m-d')])) {
            $this->views[$now->format('Y-m-d')] = 1;
        } else {
            $this->views[$now->format('Y-m-d')] ++;
        }
    }

    function getDiff() {
        if ($this->diff == null) {
            $this->diff = $this->getViewDifference();
        }
        return $this->diff;
    }

    function setDiff($diff) {
        $this->diff = $diff;
        return $this;
    }

    public function getViewDifference() {
        $now = new DateTime('NOW');
        $day = new DateInterval('P1D');
        $yesterday = clone $now;
        $yesterday->sub($day);

        $viewsYesterday = (isset($this->views[$yesterday->format('Y-m-d')])) ? $this->views[$yesterday->format('Y-m-d')] : 0;
        $viewsToday = (isset($this->views[$now->format('Y-m-d')])) ? $this->views[$now->format('Y-m-d')] : 0;

//        p($viewsYesterday);die;

        $diff = $viewsToday - $viewsYesterday;
        return $diff;
    }

}
