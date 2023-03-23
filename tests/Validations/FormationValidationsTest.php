<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationsTests
 *
 * @author vince
 */
class FormationValidationsTest extends KernelTestCase {
    public function getFormation(): Formation{
        return (new Formation())
                ->setTitle("Apprendre")
                ->setVideoId("tbXef3HXeDc");
    }
    
    public function assertErrors(Formation $formation, int $nbErreursAttendues){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues, $error);
    }
    
    public function testNonValidDateFormation(){
        $formation = $this->getFormation()->setPublishedAt(new \DateTime("2024-06-15"));
        $this->assertErrors($formation, 1);
    }
}
