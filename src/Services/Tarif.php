<?php

namespace App\Services;

use App\Entity\Billet;
use App\Entity\Commande;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Config\FileLocator;


class Tarif
{
    private $prixTotal = 0;
    private $tarif_normal;
    private $tarif_enfant;
    private $tarif_senior;
    private $tarif_reduit;
    private $tarif_bebe;

     public function __construct($tarif_bebe,$tarif_enfant,$tarif_normal,$tarif_senior,$tarif_reduit)
    {
       $this->tarif_normal=$tarif_normal;
       $this->tarif_enfant=$tarif_enfant;
       $this->tarif_senior=$tarif_senior;
       $this->tarif_reduit=$tarif_reduit;
       $this->tarif_bebe=$tarif_bebe;
    }

    public function prix($dateNaissance, $reduction)
    {
        $from = new \DateTime($dateNaissance);
        $to = new \DateTime('today');
        $age = $from->diff($to)->y;

        switch (true) {
            case $age < 4:
                $price = $this->tarif_bebe;
                break;

            case $age >= 4 AND $age < 12:
                $price = $this->tarif_enfant;
                break;

            case $age >= 12 AND $age < 60:
                if ($reduction === true) {
                    $price = $this->tarif_reduit;
                } else {
                    $price = $this->tarif_normal;
                }
                break;

            case $age > 60:
                if ($reduction === true) {
                    $price = $this->tarif_reduit;
                } else {
                    $price = $this->tarif_senior;
                }
                break;
        }
        return $price;

    }

    public function definePrice(Commande $commande)
    {
        /**
         * @var Commande $billetsTab
         */
        $billetsTab = $commande->getBillets();
        $this->prixTotal = 0;
        foreach ($billetsTab as $billet) {
            /**
             * @var Billet $billet
             */
            $billet->setPrix($this->prix($billet->getdateNaissance()->format('Y-m-d'), $billet->getReduction()));

            $this->prixTotal += $billet->getPrix();

        }
        $commande->setprixTotal($this->getPrixTotal());
    }

    public function getprixTotal()
    {

        return $this->prixTotal;
    }
}
