<?php

namespace App\Model;

class RateManager extends AbstractManager
{
    public const TABLE = 'rate';
    public const CATEGORY_TABLE = 'rate_category';
    public const ANNIVERSARY_RATE_CATEGORY = 'anniversary';
    public const STANDARD_RATE_CATEGORY = 'standard';

    public function selectAllStandardRate(): array
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' AS r';
        $query .= ' JOIN ' . self::CATEGORY_TABLE . ' AS rc ON r.rate_category_id = rc.id';
        $query .= ' WHERE rc.constant_category = \'' . self::STANDARD_RATE_CATEGORY . '\';';
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectAllAnniversaryRate(): array
    {
        $query = 'SELECT r.id, r.description, r.price FROM ' . self::TABLE . ' AS r';
        $query .= ' JOIN ' . self::CATEGORY_TABLE . ' AS rc ON r.rate_category_id = rc.id';
        $query .= ' WHERE rc.constant_category = \'' . self::ANNIVERSARY_RATE_CATEGORY . '\';';
        return $this->pdo->query($query)->fetchAll();
    }
}
