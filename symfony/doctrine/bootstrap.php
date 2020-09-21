<?php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__ . "/src");
$isDevMode = false;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '!Q2w3e4R',
    'dbname'   => 'board',
    'dbhost'   => '127.0.0.1',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
$config->setAutoGenerateProxyClasses(TRUE);
$entityManager = EntityManager::create($dbParams, $config);
$entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
$qb = $entityManager->createQueryBuilder();
