<?php

use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\db\ConnectionFactory;

$output = '<!doctype html><html lang="fr"><body>';

require_once 'vendor/autoload.php';

session_start();

ConnectionFactory::setConfig('db.config.ini');

$dispatcher = new Dispatcher();
$dispatcher->run();
