<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of UserRepositoryTest
 *
 * @author vince
 */
class UserRepositoryTest extends KernelTestCase{
    /**
    * Récupère le repository de User
    * @return UserRepository
    */
    public function recupRepository(): UserRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(UserRepository::class);
        return $repository;
    }
    
    /**
     * Création d'une instance de User
     * @return User
     */
    public function newUser(): User{
        $user = (new User())
                ->setEmail("pro@dom.com")
                ->setPassword("motdepasse");
        return $user;
    }
    
    public function testAddUser(){
        $repository = $this->recupRepository();
        $user = $this->newUser();
        $nbUsers = $repository->count([]);
        $repository->add($user, true);
        $this->assertEquals($nbUsers + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveUser () {
        $repository = $this->recupRepository();
        $user = $this->newUser();
        $repository->add($user, true);
        $nbUsers = $repository->count([]);
        $repository->remove($user, true);
        $this->assertEquals($nbUsers - 1, $repository->count([]), "erreur lors de la suppression");
    }
}
