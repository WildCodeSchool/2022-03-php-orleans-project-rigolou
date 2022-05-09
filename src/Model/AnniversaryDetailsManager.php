<?php

namespace App\Model;

class AnniversaryDetailsManager extends AbstractManager
{
    public const TABLE = 'anniversary_detail';
    public const RATE_TABLE = 'rate';

    /**
     * Get all row from database.
     */
    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT ad.id, ad.detail, r.description, ad.rate_id FROM ' . self::TABLE . ' AS ad 
        JOIN ' . self::RATE_TABLE . ' AS r ON ad.rate_id = r.id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

    public function selectAllByRateId(int $id): array|false
    {
        $query = 'SELECT ad.id, ad.detail, r.description, ad.rate_id FROM ' . self::TABLE . ' AS ad 
        JOIN ' . self::RATE_TABLE . ' AS r ON ad.rate_id = r.id WHERE ad.rate_id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function insert(array $items): void
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (detail, rate_id)
         VALUES (:detail, :rate_id)';
         $statement = $this->pdo->prepare($query);
         $statement->bindValue('detail', $items['detail'], \PDO::PARAM_STR);
         $statement->bindValue('rate_id', $items['rate_id'], \PDO::PARAM_INT);

         $statement->execute();
    }
}
