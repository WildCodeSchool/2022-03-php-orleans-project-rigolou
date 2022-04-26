<?php

namespace App\Model;

class CafeteriaManager extends AbstractManager
{
    public const TABLE = 'cafeteria';
    public const DRINK = 'drink';
    public const SNACKS = 'snack';

    public const CATEGORIES = ['boissons' => self::DRINK, 'snacks' => self::SNACKS];


    public function selectByCategory(string $category): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE  category=:category");
        $statement->bindValue('category', $category, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

}
