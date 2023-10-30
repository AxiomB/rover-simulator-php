<?php

include 'SimulationData.php';
include 'Position.php';
include 'Planet.php';
include 'Rover.php';
include 'SimulationRunner.php';

$runner = new SimulationRunner();
$runner->execute();