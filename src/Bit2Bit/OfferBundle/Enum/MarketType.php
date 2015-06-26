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
class MarketType {
    const PRIMARY = 'primary';
    const SECONDARY = 'seconadry';
    
    static function getList(){
        return array(
            self::PRIMARY => 'rynek wtórny',
            self::SECONDARY => 'rynek pierwotny',
        );
    }
}
