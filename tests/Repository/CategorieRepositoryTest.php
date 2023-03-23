<?php

namespace App\tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 * @author vince
 */
class CategorieRepositoryTest extends KernelTestCase {
    
    /**
    * Récupère le repository de Categorie
    * @return CategorieRepository
    */
    public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    /**
     * Création d'une instance de Categorie avec name
     * @return Categorie
     */
    public function newCategorie(): Categorie{
        $categorie = (new Categorie())
                ->setName("Kitsour");
        return $categorie;
    }
    
    public function testAddCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategories = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategories + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveCategorie () {
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $nbCategories = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbCategories - 1, $repository->count([]), "erreur lors de la suppression");
    }
}
