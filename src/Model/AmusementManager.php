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

    public function updateWithImage(array $items): void
    {
        $query = 'UPDATE ' . self::TABLE . ' set 
        name=:name, 
        description=:description, 
        image=:image 
        WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('name', $items['name'], \PDO::PARAM_STR);
        $statement->bindValue('description', $items['description'], \PDO::PARAM_STR);
        $statement->bindValue('image', $items['image'], \PDO::PARAM_STR);
        $statement->bindValue('id', $items['id'], \PDO::PARAM_INT);

        $statement->execute();
    }

    public function updateWithoutImage(array $items): void
    {
        $query = 'UPDATE ' . self::TABLE . ' set 
        name=:name, 
        description=:description 
        WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('name', $items['name'], \PDO::PARAM_STR);
        $statement->bindValue('description', $items['description'], \PDO::PARAM_STR);
        $statement->bindValue('id', $items['id'], \PDO::PARAM_INT);

        $statement->execute();
    }
}
