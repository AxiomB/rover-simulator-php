<?php

class Position
{
    public int $xCoord;

    public int $yCoord;

    public int $rotation;

    public function __construct(int $xCoord, int $yCoord,int $rotation)
    {
        $this->xCoord = $xCoord;
        $this->yCoord = $yCoord;
        $this->rotation = $rotation;
    }

    public function calculateNewPosition(int $rotation, int $speed): Position
    {
        $xCoord = $this->xCoord;
        $yCoord = $this->yCoord;
        switch($rotation)
        {
            case 0:     $yCoord += $speed;
                break;
            case 90:    $xCoord += $speed;
                break;
            case 180:   $yCoord -= $speed;
                break;
            case 270:   $xCoord -= $speed;
                break;
        }
        $this->rotation = $rotation;
        return new Position($xCoord, $yCoord, $this->rotation);
    }

    public function toString(): string
    {
        return $this->xCoord .',' . $this->yCoord . ' Rotation:'. $this->rotation;
    }
}