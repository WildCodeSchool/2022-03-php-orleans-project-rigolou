<?php

namespace App\Model;

class RateManager extends AbstractManager
{
    public const TABLE = 'rate';

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE . ' r INNER JOIN rate_category rc ON r.rate_category_id = rc.id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }
}
