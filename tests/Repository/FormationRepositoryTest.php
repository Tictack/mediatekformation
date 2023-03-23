<?php

namespace App\tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author vince
 */
class FormationRepositoryTest extends KernelTestCase {
   /**
    * Récupère le repository de Formation
    * @return FormationRepository
    */
    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    public function testNbFormation(){
        $repository = $this->recupRepository();
        $nbFormations = $repository->count([]);
        $this->assertEquals(237, $nbFormations);
    }
    
    /**
     * Création d'une instance de Formation avec titre, videoId et publishedat
     * @return Formation
     */
    public function newFormation(): Formation{
        $formation = (new Formation())
                ->setTitle("Apprendre")
                ->setVideoId("tbXef3HXeDc")
                ->setPublishedAt(new \DateTime("now"));
        return $formation;
    }
    
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormations + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveFormation () {
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $nbFormations = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindByContainValue() {
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findByContainValue("title", "Apprendr");
        $nbFormations = count($formations);
        $this->assertEquals(1, $nbFormations);
    }
}
