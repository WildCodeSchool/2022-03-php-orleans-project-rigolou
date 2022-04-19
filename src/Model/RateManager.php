<?php

namespace App\Model;

class RateManager extends AbstractManager
{
    public const TABLE = 'rate';
    public const CATEGORY_TABLE = 'rate_category';
    public const ANNIVERSARY_RATE_CATEGORY = 'anniversary';

    public function selectAllNotAnniversaryRate(): array
    {
        $query = 'SELECT * FROM ' . static::TABLE . ' AS r';
        $query .= ' JOIN ' . static::CATEGORY_TABLE . ' AS rc ON r.rate_category_id = rc.id';
        $query .= ' WHERE rc.constant_category != \'' . static::ANNIVERSARY_RATE_CATEGORY . '\';';
        return $this->pdo->query($query)->fetchAll();
    }
}
