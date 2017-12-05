<?php
session_start();

ini_set('display_errors', 'On');

error_reporting(E_ALL - E_NOTICE);

require_once ('../vendor/Squille/Core/helpers/constants.php');

$loader = require_once (VENDOR_DIR . 'autoload.php');
$loader->add(null, VENDOR_DIR);
$loader->add(null, SOURCE_DIR);

use Squille\Core\System;
use Squille\Core\Collection;

ini_set('max_execution_time', 0);

$config = include CONFIG_DIR . 'config.php';

if (empty($_FILES)) {
    $args = new Collection($_REQUEST);
} else {
    $args = new Collection(array_merge($_REQUEST, $_FILES));
}

$system = new System($config, $args);
$system->init();
