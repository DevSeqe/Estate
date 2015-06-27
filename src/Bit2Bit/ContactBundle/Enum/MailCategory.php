<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Bit2Bit\ContactBundle\Enum;

/**
 * Description of MailCategory
 *
 * @author Paweł
 */
class MailCategory {
   
    const OFFER = 'offer';    
    const REPORT = 'report';    
    const SEARCH = 'search';    
    const OTHER = 'other';    
    const BUY = 'buy';    
    
    static function getList(){
        return array(
            self::OTHER => 'Inne',            
            self::OFFER => 'Kontakt w sprawie oferty',            
            self::REPORT => 'Zgłoszenie oferty',            
            self::BUY => 'Sprzedaż',            
            self::SEARCH => 'Poszukiwanie',            
        );
    }
    
}
