<?php

require_once('./../vendor/autoload.php');

use Dariuszp;

$bar = new Dariuszp\CliProgressBar(10);
$bar->progress();