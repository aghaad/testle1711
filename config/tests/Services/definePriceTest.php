<?php

namespace App\Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\Tarif;
use App\Entity\Commande;
use App\Entity\Billet;

class  definePrice extends TestCase{

    
   public function testCommande()
   {
       $commande = new Commande();
       $billet = new Billet();
       $billet2 = new Billet();
       $billet3 = new Billet();
       $tarif = new Tarif(0,8,16,12,10);
       $billet->setDateNaissance(new \DateTime('1972-08-01'));
       $billet->setNom('Amrani');
       $billet->setPrenom('Aghaad');
       $billet->setPrix(16);
       $billet->setReduction(false);
       $billet2->setDateNaissance(new \DateTime('2001-11-20'));
       $billet2->setNom('Sueur');
       $billet2->setPrenom('Antoine');
       $billet2->setPrix(10);
       $billet2->setReduction(true);
       $billet3->setDateNaissance(new \DateTime('2017-08-25'));
       $billet3->setNom('Montrouge');
       $billet3->setPrenom('Hermine');
       $billet3->setPrix(0);
       $billet3->setReduction(false);
       $commande->addBillet($billet);
       $commande->addBillet($billet2);
       $commande->addBillet($billet3);
       $tarif->definePrice($commande);
       $this->assertEquals(26,$commande->getPrixTotal());
   }


}