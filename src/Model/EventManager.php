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
}
