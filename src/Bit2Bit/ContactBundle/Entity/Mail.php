<?php

namespace Bit2Bit\ContactBundle\Entity;

use Bit2Bit\ContactBundle\Enum\MailCategory;
use Bit2Bit\ContactBundle\Model\Mail as Base;

class Mail extends Base {

    const EN = 'ContactBundle:Mail';
    const ENN = 'Bit2Bit\ContactBundle\Entity\Mail';

    public function getLabel() {
        $cats = MailCategory::getList();
        switch ($this->category) {
            case MailCategory::OFFER: return '<label class="label label-primary">' . $cats[MailCategory::OFFER] . '</label>';
            case MailCategory::REPORT: return '<label class="label label-success">' . $cats[MailCategory::REPORT] . '</label>';
            case MailCategory::SEARCH: return '<label class="label label-warning">' . $cats[MailCategory::SEARCH] . '</label>';
            case MailCategory::BUY: return '<label class="label label-danger">' . $cats[MailCategory::BUY] . '</label>';
            default: return '';
        }
    }
   

}
