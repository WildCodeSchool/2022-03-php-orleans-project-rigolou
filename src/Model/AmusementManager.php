<?php

namespace App\Model;

class AmusementManager extends AbstractManager
{
    public const TABLE = 'amusement';

    public function selectFourRandom(): array
    {
        $query = 'SELECT count(*) FROM ' . self::TABLE;
        $totalRows = $this->pdo->query($query)->fetchColumn();
        if ($totalRows >= 5) {
            $randLimit = 'LIMIT ' . rand(0, $totalRows - 5) . ', 4';
            $query = 'SELECT * FROM ' . self::TABLE . ' ' . $randLimit;
            return $this->pdo->query($query)->fetchAll();
        }
        return [];
    }
}
