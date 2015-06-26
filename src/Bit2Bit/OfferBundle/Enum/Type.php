<?php

namespace Bit2Bit\OfferBundle\Enum;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Type
 *
 * @author Paweł
 */
class Type {
    const FLAT = 'flat';
    const HOUSE = 'house';
    const PLOT = 'plot';
    const LOCALE = 'locale';
    
    static function getList(){
        return array(
            self::FLAT => 'Mieszkanie',
            self::HOUSE => 'Dom',
            self::PLOT => 'Działka',
            self::LOCALE => 'Lokal'
        );
    }
}
