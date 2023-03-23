<?php

namespace App\tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author vince
 */
class PlaylistRepositoryTest extends KernelTestCase {
   /**
    * Récupère le repository de Formation
    * @return PlaylistRepository
    */
    public function recupRepository(): PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    /**
     * Création d'une instance de Formation avec titre, videoId et publishedat
     * @return Playlist
     */
    public function newPlaylist(): Playlist{
        $playlist = (new Playlist())
                ->setName("Savoir");
        return $playlist;
    } 
    
    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylists = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylists + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemovePlaylist () {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $nbPlaylists = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylists - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindByContainValue() {
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findByContainValue("name", "voir");
        $nbPlaylists = count($playlists);
        $this->assertEquals(1, $nbPlaylists);
    }
}
