<?php

namespace App\Model;

class AmusementManager extends AbstractManager
{
    public const TABLE = 'amusement';

    public function insert(array $items): void
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (name, description, image)
         VALUES (:name, :description, :image)';
         $statement = $this->pdo->prepare($query);
         $statement->bindValue('name', $items['name'], \PDO::PARAM_STR);
         $statement->bindValue('description', $items['description'], \PDO::PARAM_STR);
         $statement->bindValue('image', $items['image'], \PDO::PARAM_STR);

         $statement->execute();
    }
}
