<?php

require_once('./../vendor/autoload.php');

use Dariuszp\CliProgressBar;

$bar = new CliProgressBar(10);
$bar->progress();