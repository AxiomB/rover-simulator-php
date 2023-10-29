<?php

include 'position.php';
include 'planet.php';
include 'rover.php';
include 'simulation-runner.php';

$runner = new SimulationRunner();
$runner->execute();