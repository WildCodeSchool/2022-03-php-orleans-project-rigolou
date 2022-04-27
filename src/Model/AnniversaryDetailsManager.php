<?php

namespace App\Model;

class AnniversaryDetailsManager extends AbstractManager
{
    public const TABLE = 'anniversary_details';
    public const RATE_TABLE = 'rate';

    /**
     * Get all row from database.
     */
    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . self::TABLE . 'AS ad 
        JOIN ' . self::RATE_TABLE . ' AS r ON ad.rate_id = r.id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }
}
