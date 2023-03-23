<?php

namespace App\tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;
/**
 * Description of FormationTest
 *
 * @author vince
 */
class FormationTest extends TestCase{
    
    public function testGetDatecreationString(){
        $formation = new Formation();
        $formation->setPublishedAt(new DateTime("2023-03-15"));
        $this->assertEquals("15/03/2023", $formation->getPublishedAtString());
    }
}
