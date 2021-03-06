<?php

namespace App\Model;

class EventManager extends AbstractManager
{
    public const TABLE = 'events';

    public function selectAllPastEvents(): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE SYSDATE( ) > date ");
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectAllUpcomingEvents(): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE SYSDATE( ) < date ");
        $statement->execute();

        return $statement->fetchAll();
    }

    public function insert(array $event): void
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (title, image, description, date)
        VALUES (:title, :image, :description, :date)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('title', $event['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $event['description'], \PDO::PARAM_STR);
        $statement->bindValue('image', $event['image'], \PDO::PARAM_STR);
        $statement->bindValue('date', $event['date'], \PDO::PARAM_STR);

        $statement->execute();
    }

    public function update(array $items)
    {
        $query = 'UPDATE ' . self::TABLE . ' set 
        title=:title, 
        description=:description, 
        image=:image,
        date=:date  
        WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('title', $items['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $items['description'], \PDO::PARAM_STR);
        $statement->bindValue('image', $items['image'], \PDO::PARAM_STR);
        $statement->bindValue('id', $items['id'], \PDO::PARAM_INT);
        $statement->bindValue('date', $items['date'], \PDO::PARAM_STR);

        $statement->execute();
    }
}
