<?php

namespace App\Repository;

use App\Model\EventManager;
use App\Model\User;

class UserRepository
{
    public static function find(\PDO $pdo, int $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";

        $prepare = $pdo->prepare($sql);

        $prepare->execute([
            ":id" => $id
        ]);

        $result = $prepare->fetchObject(User::class);

        EventManager::trigger("database.user.log", ['user' => $result]);

        return $result;
    }

    public static function findAll(\PDO $pdo)
    {
        $sql = "SELECT * FROM users";

        $prepare = $pdo->query($sql);
        $prepare->execute();

        $result = $prepare->fetchAll(\PDO::FETCH_CLASS, User::class);
        return $result;
    }

    public static function persist(\PDO $pdo, User $user)
    {

        $sql = "UPDATE users SET history_count = :val where id = :id";

        $prepare = $pdo->prepare($sql);

        $prepare->execute([
            ":id" => $user->id,
            ":val" => ++$user->history_count
        ]);

        // $result = $prepare->fetchObject(User::class);
        // return $result;
    }
}
