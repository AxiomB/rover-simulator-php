<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use exceptions\CalculateNewPositionException;

final class PositionTest extends TestCase
{

    public function testDisplayInString()
    {
        $this->assertSame(true, true);
    }

    public function testCalculateNewPositionIncorrectRotation()
    {
        $this->expectException(CalculateNewPositionException::class);
        $testPosition = new Position(2,2,90);
        $testPosition->calculateNewPosition(45,1);
    }

    public function testCalculateNewPositionWithCorrectRotations()
    {

        try {
            $testPosition = new Position(2,2,90);
            $testPosition = $testPosition->calculateNewPosition(90,1);

            $finalPosition = new Position(3,2,90);

            $this->assertEquals($testPosition->toString(), $finalPosition->toString());
        }
        catch (Exception $e) {
            self::fail("Exception Ocurred During Test Execution: ".$e->getMessage());
        }
    }
}