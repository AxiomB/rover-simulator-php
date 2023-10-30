<?php

use exceptions\PositionOutOfPlanetBounds;
use exceptions\RoverCommandFailed;
use \exceptions\CalculateNewPositionException;

class Rover
{
    private Position $currentPosition;

    private int $speed;

    private array $validCommands = [];

    public function __construct(int $xCoordinate, int $yCoordinate, int $dir, int $speed)
    {
        $this->validCommands = ["F","L","R"];
        $this->speed = $speed;
        $this->currentPosition = new Position($xCoordinate, $yCoordinate, $dir);
    }

    public function getCurrentPosition(): Position
    {
        return $this->currentPosition;
    }

    private function isCommandValid(string &$command): bool
    {
        if(ctype_lower($command))
        {
            $command = strtoupper($command);
        }
        return in_array($command, $this->validCommands);
    }

    /**
     * @throws RoverCommandFailed
     */
    private function getNewProposedPosition($command) : Position
    {
        $degreesToRotate = 0;
        if($command == "L")
        {
            $degreesToRotate = -90;
        }
        else if($command == "R")
        {
            $degreesToRotate = 90;
        }
        $finalRotationDegrees = ($this->currentPosition->rotation + $degreesToRotate) % 360;
        $finalRotationDegrees = $finalRotationDegrees < 0 ? $finalRotationDegrees + 360 : $finalRotationDegrees;

        try {
            return $this->currentPosition->calculateNewPosition($finalRotationDegrees, $this->speed);
        } catch (CalculateNewPositionException $e) {
            throw new RoverCommandFailed("Error, moving the rover, position couldn't be calculated ".$e->getMessage());
        }
    }

    /**
     * @throws RoverCommandFailed
     */
    public function processCommand(string $command, Planet &$planet): void
    {
        if(!$this->isCommandValid($command))
        {
            throw new RoverCommandFailed("Error moving the rover, command is incorrect");
        }
        try {
            $nextPosition = $this->getNewProposedPosition($command);
            $planet->removeObjectFromPosition($this->currentPosition) ? : throw new RoverCommandFailed("Error moving the rover, rover wasn't at expected position to remove");
            $planet->placeObjectAtPosition($nextPosition) ? : throw new RoverCommandFailed("Error moving the rover, obstacle was present at coordinates");
            $this->currentPosition = $nextPosition;
        }
        catch (PositionOutOfPlanetBounds) {
            throw new RoverCommandFailed('Error moving the rover, new position is out of planet bounds');
        }
    }
}