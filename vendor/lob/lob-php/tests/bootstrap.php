<?php

error_reporting(E_ALL | E_STRICT);

// Ensure that composer has installed all dependencies
if (!file_exists(dirname(__DIR__) . '/composer.lock')) {
    die("Dependencies must be installed using composer:\n\nphp composer.phar install --dev\n\n"
        . "See http://getcomposer.org for help with installing composer\n");
}

require __DIR__.'/../vendor/autoload.php';

if (!defined('LOB_TEST_API_KEY') || LOB_TEST_API_KEY === 'YOUR_LOB_TEST_API_KEY') {
    exit('Please, define LOB_TEST_API_KEY constant in the PHPUnit XML' . PHP_EOL);
}