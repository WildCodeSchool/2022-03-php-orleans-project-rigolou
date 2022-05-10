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
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`name`, `price`, `category`) 
        VALUES (:name, :price, :category)");
        $statement->bindValue('name', $cafeteria['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $cafeteria['price']);
        $statement->bindValue('category', $cafeteria['category'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $cafeteria): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET
        `name`=:name,
        `price`=:price,
        `category`=:category
        WHERE id=:id");
        $statement->bindValue('name', $cafeteria['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $cafeteria['price']);
        $statement->bindValue('category', $cafeteria['category'], \PDO::PARAM_STR);
        $statement->bindValue('id', $cafeteria['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
