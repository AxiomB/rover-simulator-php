<?php

use exceptions\CalculateNewPositionException;

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

    /**
     * @throws CalculateNewPositionException
     */
    public function calculateNewPosition(int $rotation, int $moves): Position
    {
        $xCoord = $this->xCoord;
        $yCoord = $this->yCoord;
        switch($rotation)
        {
            case 0:     $yCoord += $moves;
                break;
            case 90:    $xCoord += $moves;
                break;
            case 180:   $yCoord -= $moves;
                break;
            case 270:   $xCoord -= $moves;
                break;
            default:    throw new CalculateNewPositionException("Rotation Incorrect, rotation given".$rotation.' error ');
        }
        $this->rotation = $rotation;
        return new Position($xCoord, $yCoord, $this->rotation);
    }

    public function toString(): string
    {
        return $this->xCoord .',' . $this->yCoord . ' Rotation:'. $this->rotation;
    }
}