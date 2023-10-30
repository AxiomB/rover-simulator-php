<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use \exceptions\RoverCommandFailed;

class RoverTest extends TestCase
{
    public function testGetCurrentPosition()
    {
        $testRover = new Rover(1,1, 0, 1);
        $referencePosition = new Position(1,1,0);
        $this->assertEquals($referencePosition->toString(), $testRover->getCurrentPosition()->toString());
    }

    public function testProcessCorrectCommand()
    {
        $testPlanet = new Planet(200);
        $testRover = new Rover(2,2,180,1);
        $testPlanet->placeObjectAtPosition($testRover->getCurrentPosition());
        $testRover->processCommand("F",$testPlanet);
        $referencePosition = new Position(2,1,180);
        $this->assertEquals($referencePosition->toString(),$testRover->getCurrentPosition()->toString());
    }

    public function testProcessNonRecognizedCommand()
    {
        $this->expectException(RoverCommandFailed::class);
        $testPlanet = new Planet(200);
        $testRover = new Rover(2,2,180,1);
        $testPlanet->placeObjectAtPosition($testRover->getCurrentPosition());
        $testRover->processCommand("T",$testPlanet);
        $referencePosition = new Position(2,1,180);
        $this->assertEquals($referencePosition->toString(),$testRover->getCurrentPosition()->toString());
    }
}