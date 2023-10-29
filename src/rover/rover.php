<?php

class Rover
{
    private Position $currentPosition;

    private int $speed;

    private array $validCommands = [];

    public function __construct(int $xCoordinate, int $yCoordinate, string $dir, int $speed)
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

        return $this->currentPosition->calculateNewPosition($finalRotationDegrees, $this->speed);
    }

    public function processCommand(string $command, Planet &$planet): bool
    {
        if(!$this->isCommandValid($command))
        {
            return false;
        }
        $nextPosition = $this->getNewProposedPosition($command);
        $roverMoved = $planet->removeObjectFromPosition($this->currentPosition) && $planet->placeObjectAtPosition($nextPosition);
        if($roverMoved)
        {
            $this->currentPosition = $nextPosition;
        }
        return $roverMoved;
    }
}