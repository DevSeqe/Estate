<?php

namespace Bit2Bit\ContactBundle\Manager;

use Bit2Bit\BaseBundle\Manager\AbstractManager;

class MailManager extends AbstractManager {

    const SERVICE = 'bit2bit.contactbundle.mail';

    public function countUnread($user){
        $qb = $this->repository->createQueryBuilder('m');
        $qb->where("m.owner = ?1")
                ->andWhere("m.readed = ?2")
                ->setParameter(1, $user)
                ->setParameter(2, false)
                ->orderBy('m.created', 'DESC');
        $query = $qb->getQuery();
        $mails = $query->execute(); /* @var $mails Mail[] */
        $count = count($mails);
        
        if($count == 0){
            return false;
        }
        return $count;
    }
    
    public function findUserMails($user){
        $qb = $this->repository->createQueryBuilder('m');
        $qb->where("m.owner = ?1")
                ->setParameter(1, $user)
                ->orderBy('m.created', 'DESC');
        $query = $qb->getQuery();
        $mails = $query->execute(); /* @var $mails Mail[] */

        return $mails;
    }
    
    public function getMailGroup($group){
        $qb = $this->repository->createQueryBuilder('m');
        $qb->where("m.mailGroup = ?1")
                ->setParameter(1, $group)
                ->orderBy('m.created', 'DESC');
        $query = $qb->getQuery();
        $mails = $query->execute(); /* @var $mails Mail[] */

        return $mails;
    }
}
