<?php

namespace Bit2Bit\NewsletterBundle\Manager;

use Bit2Bit\BaseBundle\Manager\AbstractManager;
use Bit2Bit\NewsletterBundle\Entity\Subscriber;

class SubscriberManager extends AbstractManager {

    const SERVICE = 'bit2bit.newsletterbundle.subscriber';

    public function findNewest() {
        $qb = $this->repository->createQueryBuilder('s');
        $qb->where("s.active = ?1")
                ->setParameter(1, true)
                ->orderBy('s.joined', 'DESC')
                ->setMaxResults(5);
        $query = $qb->getQuery();
        $subscribers = $query->execute(); /* @var $subscribers Subscriber[] */

        return $subscribers;
    }

}
