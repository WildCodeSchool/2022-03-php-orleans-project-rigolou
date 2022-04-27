<?php

namespace App\Model;

class EventsManager extends AbstractManager
{
    public const TABLE = 'events';

    public function selectAllPastEvents(): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE SYSDATE( ) > date ");
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectAllUpcomingEvents(): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE SYSDATE( ) < date ");
        $statement->execute();

        return $statement->fetchAll();
    }

}
