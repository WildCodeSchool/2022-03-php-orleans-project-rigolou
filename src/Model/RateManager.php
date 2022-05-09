<?php

namespace App\Model;

class RateManager extends AbstractManager
{
    public const TABLE = 'rate';
    public const CATEGORY_TABLE = 'rate_category';
    public const ANNIVERSARY_RATE_CATEGORY = 'anniversary';
    public const STANDARD_RATE_CATEGORY = 'standard';

    public function selectAllByCategory(): array
    {
        $query = 'SELECT r.id, r.description, r.price, r.rate_category_id,
         rc.id AS category_id, rc.category FROM ' . self::TABLE . ' AS r
         JOIN ' . self::CATEGORY_TABLE . ' AS rc ON r.rate_category_id=rc.id
         ORDER BY category ASC, description ASC';
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectAllStandardRate(): array
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' AS r
         JOIN ' . self::CATEGORY_TABLE . ' AS rc ON r.rate_category_id = rc.id
         WHERE rc.constant_category = \'' . self::STANDARD_RATE_CATEGORY . '\'';
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectAllAnniversaryRate(): array
    {
        $query = 'SELECT r.id, r.description, r.price FROM ' . self::TABLE . ' AS r
         JOIN ' . self::CATEGORY_TABLE . ' AS rc ON r.rate_category_id = rc.id
         WHERE rc.constant_category = \'' . self::ANNIVERSARY_RATE_CATEGORY . '\'';
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectAllRateCategory(): array
    {
        $query = 'SELECT * FROM ' . self::CATEGORY_TABLE;
        return $this->pdo->query($query)->fetchAll();
    }

    public function insert(array $items): void
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (description, price, rate_category_id)
         VALUES (:description, :price, :category)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('description', $items['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $items['price'], \PDO::PARAM_STR);
        $statement->bindValue('category', $items['category'], \PDO::PARAM_INT);

        $statement->execute();
    }

    public function update(array $items): void
    {
        $query = 'UPDATE ' . self::TABLE . ' SET description=:description, price=:price, 
        rate_category_id=:rate_category_id WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('description', $items['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $items['price'], \PDO::PARAM_STR);
        $statement->bindValue('rate_category_id', $items['category'], \PDO::PARAM_INT);
        $statement->bindValue('id', $items['id'], \PDO::PARAM_INT);

        $statement->execute();
    }
}
