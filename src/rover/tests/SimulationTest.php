<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;


class SimulationTest extends TestCase
{

    public function testRunCorrectDataSimulation()
    {
        $testSimulationRunner = new SimulationRunner();
        $testSimulationData = new SimulationData();
        $testSimulationData->initialRoverPosition = "100,100";
        $testSimulationData->startingDirectionInDegrees = 90;
        $testSimulationData->newPlanetSize = "200";
        $testSimulationData->roverCommands = "FFRRFFFRL";
        $testSimulationRunner->execute($testSimulationData);
    }
}