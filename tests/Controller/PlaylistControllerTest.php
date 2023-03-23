<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistControllerTest
 *
 * @author vince
 */
class PlaylistControllerTest extends WebTestCase{
    
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        // simulation de la soumission du formaulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Eclipse et Java'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la playlist correspond à la recherche
        $this->assertSelectorTextContains('h5', 'Eclipse et Java');
    }
    
    public function testTriPlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/name/DESC');
        $this->assertSelectorTextContains('h5', 'Visual Studio 2019 et C#');
        $client->request('GET', '/playlists/tri/name/ASC');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    
    public function testTriNbFormations(){
        $client = static::createClient();
        $client->request('GET', '/playlists/tri/nbformations/DESC');
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
        $client->request('GET', '/playlists/tri/nbformations/ASC');
        $this->assertSelectorTextContains('h5', 'Cours Informatique embarquée');
    }
    
    public function testLinkPlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists');
        // clic sur le lien (le nom d'une ville)
        $client->clickLink("Voir détail");
        // récupération du résultat du clic
        $response = $client->getResponse();
//        dd($client->getRequest());
        // contrôle si le client existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        // récupération de la route et contrôle qu'elle est correcte
        $uri = $client->getRequest()->server->get('REQUEST_URI');
        $this->assertEquals('/playlists/playlist/13', $uri);
        $this->assertSelectorTextContains('h4','Bases de la programmation (C#)');
    }
}
