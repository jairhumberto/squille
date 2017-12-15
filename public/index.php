<?php
session_start();

use Squille\Core\System;
use Squille\Core\Collection;

error_reporting(E_ALL - E_NOTICE);

ini_set('max_execution_time', 0);

require '..'
      . DIRECTORY_SEPARATOR . 'vendor'
      . DIRECTORY_SEPARATOR . 'autoload.php';

$config = include '..'
                . DIRECTORY_SEPARATOR . 'source'
                . DIRECTORY_SEPARATOR . 'config.php';

if (empty($_FILES)) {
    $args = new Collection($_REQUEST);
} else {
    $args = new Collection(array_merge($_REQUEST, $_FILES));
}

$system = new System($config, $args);
$system->init();
