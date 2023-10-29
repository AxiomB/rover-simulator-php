<?php

class Planet
{
    private int $size;

    private array $obstacles = [];

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    private function isObstacleAtCoordinates(int $xCoord,int $yCoord): bool
    {
        $filteredObstacles = array_filter($this->obstacles, function($element) use($xCoord,$yCoord) {
            if(isset($element->xCoord) && isset($element->yCoord))
            {
                return $element->xCoord == $xCoord && $element->yCoord == $yCoord;
            }
            return null;
        });
        return count($filteredObstacles) > 0;
    }

    public function placeObjectAtPosition(Position $newPosition): bool
    {
        if(($newPosition->xCoord > $this->size || $newPosition->yCoord > $this->size) || ($newPosition->xCoord < 0 || $newPosition->yCoord < 0))
        {
            return false;
        }

        if($this->isObstacleAtCoordinates($newPosition->xCoord, $newPosition->yCoord))
        {
            return false;
        }

        $this->obstacles[] = $newPosition;
        return true;
    }

    public function removeObjectFromPosition(Position $position): bool
    {
        if(($position->xCoord > $this->size || $position->yCoord > $this->size) || ($position->xCoord < 0 || $position->yCoord < 0))
        {
            return false;
        }

        if(!$this->isObstacleAtCoordinates($position->xCoord, $position->yCoord))
        {
            return false;
        }

        $this->obstacles = array_filter($this->obstacles, function($element) use($position) {
            if(isset($element->xCoord) && isset($element->yCoord))
            {
                return $element->xCoord != $position->xCoord && $element->yCoord != $position->yCoord;
            }
            return null;
        });
        return true;
    }
}