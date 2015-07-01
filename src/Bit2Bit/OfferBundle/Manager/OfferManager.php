<?php

namespace Bit2Bit\OfferBundle\Manager;

use Bit2Bit\BaseBundle\Manager\AbstractManager;
use Bit2Bit\OfferBundle\Entity\Offer;

class OfferManager extends AbstractManager {

    const SERVICE = 'bit2bit.offerbundle.offer';

    public function searchOffers($data) {
        $qb = $this->repository->createQueryBuilder('o');
        $qb->where("o.published = ?1")
                ->andWhere("o.type = ?2")
                ->andWhere("o.rent = ?4");
        if($data['market_type'] != 'both'){
            $qb->andWhere("o.marketType = ?3")
                ->setParameter(3, $data['market_type']);
        }                
        $qb->setParameter(1, true)
                ->setParameter(2, $data['object_type']);                
        if ($data['localization'] != "") {
            $qb->leftJoin('o.localization', 'l');
            $localizationParts = explode(" ", $data['localization']);
            $locQuery = array();
            foreach ($localizationParts as $part) {
                $part = trim($part, " \t\n.,");
                if (!in_array($part, array('ul')) && $part != "") {
                    $locQuery[] = "l.city LIKE '%$part%'";
                    $locQuery[] = "l.street LIKE '%$part%'";
                }
            }
            if (!empty($locQuery)) {
                $locQuery = implode(" OR ", $locQuery);
                $qb->andWhere($locQuery);
            }
        }

        if ($data["offer_type"] == "rent") {
            $qb->setParameter(4, true);
        } else {
            $qb->setParameter(4, false);
        }

        $query = $qb->getQuery();
        $offers = $query->execute(); /* @var $offers Offer[] */

        if ($data['price_max'] != "" || $data['price_min'] != "") {
            $filteredOffers = array();
            $min = ($data['price_min'] == "") ? 0 : (float) $data['price_min'];
            $max = ($data['price_max'] == "") ? false : (float) $data['price_max'];
            foreach ($offers as $offer) {
                if ($max !== false) {
                    if ($offer->getPrice(true) >= $min && $offer->getPrice(true) <= $max) {
                        $filteredOffers[] = $offer;
                    }
                } else {
                    if ($offer->getPrice(true) >= $min) {
                        $filteredOffers[] = $offer;
                    }
                }
            }
            $offers = $filteredOffers;
        }

        if ($data['area_max'] != "" || $data['area_min'] != "") {
            $filteredOffers = array();
            $min = ($data['area_min'] == "") ? 0 : (float) $data['area_min'];
            $max = ($data['area_max'] == "") ? false : (float) $data['area_max'];
            foreach ($offers as $offer) {
                if ($max !== false) {
                    if ($offer->getArea() >= $min && $offer->getArea() <= $max) {
                        $filteredOffers[] = $offer;
                    }
                } else {
                    if ($offer->getArea() >= $min) {
                        $filteredOffers[] = $offer;
                    }
                }
            }
            $offers = $filteredOffers;
        }

        if ($data['rooms_max'] != "" || $data['rooms_min'] != "") {
            $filteredOffers = array();
            $min = ($data['rooms_min'] == "") ? 0 : (float) $data['rooms_min'];
            $max = ($data['rooms_max'] == "") ? false : (float) $data['rooms_max'];
            foreach ($offers as $offer) {
                if ($max !== false) {
                    if ($offer->getRooms() >= $min && $offer->getRooms() <= $max) {
                        $filteredOffers[] = $offer;
                    }
                } else {
                    if ($offer->getRooms() >= $min) {
                        $filteredOffers[] = $offer;
                    }
                }
            }
            $offers = $filteredOffers;
        }

        return $offers;
    }

    public function findNewest() {
        $qb = $this->repository->createQueryBuilder('o');
        $qb->where("o.published = ?1")
                ->setParameter(1, true)
                ->orderBy('o.created', 'DESC')
                ->setMaxResults(3);
        $query = $qb->getQuery();
        $offers = $query->execute(); /* @var $offers Offer[] */

        return $offers;
    }
    
    public function findSimilar($offer) {
        $qb = $this->repository->createQueryBuilder('o');
        $qb->where("o.published = ?1")
                ->leftJoin("o.localization", "l")
                ->andWhere("o.type = ?2")
                ->andWhere("l.city LIKE ?3")                
                ->setParameter(1, true)
                ->setParameter(2, $offer->getType())
                ->setParameter(3, "%".$offer->getLocalization()->getCity()."%")
                ->orderBy('o.created', 'DESC')
                ->setMaxResults(3);
        $query = $qb->getQuery();
        $offers = $query->execute(); /* @var $offers Offer[] */
        
        $flatOffers = array();
        
        foreach($offers as $offer){
            $row = array(
                'id' => $offer->getId(),
                'thumb' => $offer->getThumbnail(),
                'city' => $offer->getLocalization()->getCity(),
                'area' => $offer->getArea()
            );
            $flatOffers[] = $row;
        }
        return $flatOffers;
    }

}
