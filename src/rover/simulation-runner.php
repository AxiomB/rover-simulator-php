<?php

class SimulationData
{
    public string $newPlanetSize = "";
    public string $initialRoverPosition ="";
    public int $startingDirectionInDegrees = 0;
    public string $roverCommands = "";
}

class SimulationRunner
{
    private Planet $planet;
    private array $validDirections = [];
    private array $validCommands = [];
    private array $directionToDegreesConversion = [];

    public function __construct()
    {
        $this->validDirections = ["N", "S", "E", "W"];
        $this->validCommands = ["F","L","R"];
        $this->directionToDegreesConversion = ["N" => 0, "E" => 90, "S" => 180, "W" => 270 ];
    }

    private function generateRandomPlanet($size): void //TODO Improve planet generation
    {
        $this->planet = new Planet($size);
        $obstaclesNumber = rand(0, $size);
        for($i = 0; $i < $obstaclesNumber; $i++)
        {
            $this->planet->placeObjectAtPosition(new Position(rand(0, $size), rand(0, $size), 0));
        }
    }

    private function validateDirection(string $direction): bool
    {
        if(ctype_lower($direction))
        {
            $direction = strtoupper($direction);
        }
        return in_array($direction, $this->validDirections);
    }

    private function validateInitialRoverCoordinates(int $xCoord,int $yCoord): bool
    {
        $planetSize = $this->planet->getSize();
        return $xCoord > 0 && $xCoord <= $planetSize && $yCoord > 0 && $yCoord <= $planetSize;
    }

    private function validateRoverCommands(string $commands): bool //TODO Refactor command validation
    {
        $commandArray = str_split($commands, 1);
        foreach($commandArray as $command)
        {
            if(ctype_lower($command))
            {
                $command = strtoupper($command);
            }
            return in_array($command, $this->validCommands);
        }
        return true;
    }

    private function directionToDegrees(string $direction): int
    {
        if(ctype_lower($direction))
        {
            $direction = strtoupper($direction);
        }
        return $this->directionToDegreesConversion[$direction];
    }

    private function getParametersFromUser(): SimulationData
    {
        print "Welcome to Rover Simulator, please, follow instructions to write the input correctly\n";
        print "First, write the size of the planet (minimum size is 2, maximum is 9999)  \n";

        $simulationRunData = new SimulationData();

        while($newPlanetSize = readline())
        {
            if($newPlanetSize >= 2 && $newPlanetSize <= 9999)
            {
                $this->generateRandomPlanet($newPlanetSize);
                $simulationRunData->newPlanetSize = $newPlanetSize;
            }
            else
            {
                print "Incorrect Value, please try again\n";
            }
        }
        print "Second, write a valid position for the Rover on the next format: x_coordinate,y_coordinate \n";
        while($initialRoverPosition = readline())
        {
            $coords = explode(",",$initialRoverPosition);
            if($this->validateInitialRoverCoordinates(intval($coords[0], 10), intval($coords[1], 10)))
            {
                $simulationRunData->initialRoverPosition = $initialRoverPosition;
            }
            else
            {
                print "Incorrect Value, please try again\n";
            }
        }
        print "Thirdly, write a starting direction for the rover, valid directions are [N,S,E,W] \n";
        while($startingDirection = readline())
        {
            if($this->validateDirection($startingDirection))
            {
                $simulationRunData->startingDirectionInDegrees = $this->directionToDegrees($startingDirection);
            }
            else
            {
                print "Incorrect Value, please try again\n";
            }
        }
        print "Now write the series of commands for the rover, valid commands are [F,L,R] \n";
        while($roverCommands = readline())
        {
            if($this->validateRoverCommands($roverCommands))
            {
                $simulationRunData->roverCommands = $roverCommands;
            }
            else
            {
                print "Incorrect Value, please try again\n";
            }
        }
        return $simulationRunData;
    }

    private function executeSimulationWithData(SimulationData $simulationRunData): void
    {

        $coords = explode(",",$simulationRunData->initialRoverPosition);
        $rover = new Rover(intval($coords[0], 10), intval($coords[1], 10), $simulationRunData->startingDirectionInDegrees, 1);

        $commands = str_split($simulationRunData->roverCommands, 1);
        $commandResult = true;

        $this->planet->placeObjectAtPosition($rover->getCurrentPosition());

        for($i = 0;$i < count($commands) && $commandResult; $i++)
        {
            $commandResult = $rover->processCommand($commands[$i], $this->planet);
            print "New Position and Rotation Is:" . $rover->getCurrentPosition()->toString() . "\n";
        }

        if($commandResult)
        {
            print "Commands Executed Without Errors \n";
        }
        else
        {
            print "Commands Executed With Errors: \n";
        }
    }

    public function execute(SimulationData $preloadedData = null)
    {
        if($preloadedData == null)
        {
            $simulationRunData = $this->getParametersFromUser();
        }
        else
        {
            $simulationRunData = $preloadedData;
        }
        $this->executeSimulationWithData($simulationRunData);
    }
}