<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use exceptions\PositionOutOfPlanetBounds;

final class PlanetTest extends TestCase
{
    private int $planetSize = 200;

    private function buildTestPlanet(): Planet
    {
        return new Planet($this->planetSize);
    }

    public function testGetSize()
    {
        $testPlanet = $this->buildTestPlanet();
        $this->assertEquals(200, $testPlanet->getSize());
    }

    public function testPlaceObjectAtCorrectPosition()
    {
        $obstaclePosition = new Position(3,3,0);
        $testPlanet = $this->buildTestPlanet();
        $testPlanet->placeObjectAtPosition($obstaclePosition);
        $this->assertTrue($testPlanet->isObstacleAtCoordinates(3,3));
    }

    public function testPlaceObjectAtOutOfBoundsPosition()
    {
        $this->expectException(PositionOutOfPlanetBounds::class);
        $obstaclePosition = new Position(201,201,0);
        $testPlanet = $this->buildTestPlanet();
        $testPlanet->placeObjectAtPosition($obstaclePosition);
    }

    public function testPlaceObjectAtOccupiedPosition()
    {
        $obstaclePosition = new Position(3,3,0);
        $testPlanet = $this->buildTestPlanet();
        $testPlanet->placeObjectAtPosition($obstaclePosition);
        $this->assertFalse($testPlanet->placeObjectAtPosition($obstaclePosition));
    }

    public function testRemoveObjectAtCorrectPosition()
    {
        $obstaclePosition = new Position(3,3,0);
        $testPlanet = $this->buildTestPlanet();
        $testPlanet->placeObjectAtPosition($obstaclePosition);
        $this->assertTrue($testPlanet->removeObjectFromPosition($obstaclePosition));
    }

    public function testRemoveObjectAtOutOfBoundsPosition()
    {
        $this->expectException(PositionOutOfPlanetBounds::class);
        $obstaclePosition = new Position(201,201,0);
        $testPlanet = $this->buildTestPlanet();
        $testPlanet->removeObjectFromPosition($obstaclePosition);
    }

    public function testRemoveObjectAtEmptyPosition()
    {
        $obstaclePosition = new Position(4,4,0);
        $testPlanet = $this->buildTestPlanet();
        $this->assertFalse($testPlanet->removeObjectFromPosition($obstaclePosition));
    }
}