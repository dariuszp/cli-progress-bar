<?php

require_once('./../vendor/autoload.php');

use Dariuszp\CliProgressBar;

$bar = new CliProgressBar(350);
$bar->display();

while($bar->getCurrentstep() < $bar->getSteps()) {
    usleep(50000);
    $bar->progress();
}

$bar->end();