<?php

require "vendor/autoload.php";

use App\PDO\FactoryPDO;
use App\Model\Migration;
use App\Model\EventManager;
use App\Repository\UserRepository;

$pdo = FactoryPDO::buildSqlite("sqlite:" . __DIR__ . "/_data/database.db");

// $migration = new Migration;
// $migration->setData($pdo);

// Bind les events
EventManager::attach('database.user.log', function ($args) use ($pdo) {
    UserRepository::persist($pdo, $args['user']);
});

// Creations des users
print_r(UserRepository::find($pdo, 1));
