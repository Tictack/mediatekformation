<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationsControllerTest
 *
 * @author vince
 */
class FormationsControllerTest extends WebTestCase{
    
    public function testFiltreFormation(){
        $client = static::createClient();
        $client->request('GET', '/formations');
        // simulation de la soumission du formaulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Cours Programmation Objet'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la formation correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Cours Programmation Objet');
    }
    
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET','/formations/recherche/name/playlist');
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Cours Curseurs'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(2, $crawler->filter('h5'));
        // vérifie si la formation correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Cours Curseurs');
    }
    
    public function testTriFormation(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/title/DESC');
        $this->assertSelectorTextContains('h5', 'UML : Diagramme de paquetages');
        $client->request('GET', '/formations/tri/title/ASC');
        $this->assertSelectorTextContains('h5', 'Android Studio (complément n°1) : Navigation Drawer et Fragment');
    }
    
    public function testTriPlaylist(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/name/DESC/playlist');
        $this->assertSelectorTextContains('h5', 'C# : ListBox en couleur');
        $client->request('GET', '/formations/tri/name/ASC/playlist');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation n°74 - POO : collections');
    }
    
    public function testTriDate(){
        $client = static::createClient();
        $client->request('GET', '/formations/tri/publishedAt/DESC');
        $this->assertSelectorTextContains('h5', 'Eclipse n°8 : Déploiement');
        $client->request('GET', '/formations/tri/publishedAt/ASC');
        $this->assertSelectorTextContains('h5', 'Cours UML (1 à 7 / 33) : introduction et cas d\'utilisation');
    }
    
    public function testLinkFormation(){
        $client = static::createClient();
        $client->request('GET', '/formations');
        // clic sur le lien (le nom d'une ville)
        $client->clickLink("Formation miniature");
        // récupération du résultat du clic
        $response = $client->getResponse();
//        dd($client->getRequest());
        // contrôle si le client existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        // récupération de la route et contrôle qu'elle est correcte
        $uri = $client->getRequest()->server->get('REQUEST_URI');
        $this->assertEquals('/formations/formation/1', $uri);
        $this->assertSelectorTextContains('h4','Eclipse n°8 : Déploiement');
    }
}
