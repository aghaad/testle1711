<?php

namespace App\Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\Tarif;
use App\Entity\Commande;
use App\Entity\Billet;

class TarifTest extends TestCase{

    public function testPrix()
    {
       $tarif = new Tarif(0,8,16,12,10);
       $this->assertEquals(0,  $tarif->Prix('2016-12-25',false));
       $this->assertEquals(12, $tarif->Prix('1950-12-25',false));
       $this->assertEquals(16, $tarif->Prix('2000-12-25',false));
       $this->assertEquals(16, $tarif->Prix('1995-12-25',false));
       $this->assertEquals(8,  $tarif->Prix('2012-12-25',false));
       $this->assertEquals(0,  $tarif->Prix('2016-12-25',true));
       $this->assertEquals(10, $tarif->Prix('1950-12-25',true));
       $this->assertEquals(10, $tarif->Prix('2000-12-25',true));
       $this->assertEquals(10, $tarif->Prix('1995-12-25',true));
       $this->assertEquals(10, $tarif->Prix('1900-12-25',true));
   }
   

}