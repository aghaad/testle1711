<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Field\FormField;


class HomeControllerTest extends WebTestCase
{
    private $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = static::createClient();
        
    }

    public function testShowIndex()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    public function testFormSubmitTwo()
    {
        $crawler = $this->client->request('GET', '/form');
        $form = $crawler->selectButton('commande[valider]')->form();

        $values = $form->getPhpValues();
// set some values
        $form['commande[DateCommande]'] = '2019-12-12';
        $form['commande[Formule]']->select(true);
        $form['commande[NbBillet]']->select(2);
        $form['commande[email]'] = 'lucas@email.com';

        $values = $form->getPhpValues();
        // Billet 1
        $values['commande']['billets'][0]['nom'] = 'Jeano';
        $values['commande']['billets'][0]['prenom'] = 'Luc';
        $values['commande']['billets'][0]['dateNaissance'] = '04/12/1990';
        $values['commande']['billets'][0]['pays'] = 'FR';
        $values['commande']['billets'][0]['reduction'] = '0';
        // Billet 2
        $values['commande']['billets'][1]['nom'] = 'David';
        $values['commande']['billets'][1]['prenom'] = 'Julien';
        $values['commande']['billets'][1]['dateNaissance'] = '26/12/2010';
        $values['commande']['billets'][1]['pays'] = 'FR';
        $values['commande']['billets'][1]['reduction'] = '0';

// submit the form
        $crawler = $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        $this->assertEquals(24, $crawler->filter('#total')->text());
    }


}