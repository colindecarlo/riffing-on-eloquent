<?php

require __DIR__ . '/../bootstrap/autoload.php';

$autoloader = require __DIR__ . '/../vendor/autoload.php';
$autoloader->addPsr4("App\\", "tests", $prepend = true);
