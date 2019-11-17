<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Services;

/**
 * Description of Stripe
 *
 * 
 */
class StripePayment {
    
    public function StripePayment($prixTTC, $token) {

        try {
            \Stripe\Stripe::setApiKey("sk_test_o3dWOEWWdz5VCWsT9ucaY3xh00nf4ow6WN");


           return \Stripe\Charge::create([
                'amount' => $prixTTC,
                'currency' => 'eur',
                'description' => 'Paiement final',
                'source' => $token,
                'receipt_email' => 'le.musee.du.louvre.75@gmail.com',
            ]);
        } catch (\Exception $e) {
            
            return false;
          
        }
    }
}
