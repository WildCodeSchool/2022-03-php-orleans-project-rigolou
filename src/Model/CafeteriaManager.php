<?php

namespace App\Model;

class CafeteriaManager extends AbstractManager
{
    public const TABLE = 'cafeteria';
    public const DRINK = 'drink';
    public const SNACKS = 'snack';

    public function selectByCategory(string $category): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE  category=:category");
        $statement->bindValue('category', $category, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function insert(array $cafeteria): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`) VALUES (:name)");
        $statement->bindValue('name', $cafeteria['name'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
