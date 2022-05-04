<?php

namespace App\Model;

class AnniversaryManager extends AbstractManager
{
    public const TABLE = "anniversary_reservation";

    public function insert(array $items): void
    {
        $query = 'INSERT INTO ' . self::TABLE .
        ' (firstname, lastname, phone, email, reservation_date, rate_id, message)
         VALUES (:firstname , :lastname, :phone, :email, :reservation_date, :rate_id, :message)';
         $statement = $this->pdo->prepare($query);
         $statement->bindValue('firstname', $items['firstname'], \PDO::PARAM_STR);
         $statement->bindValue('lastname', $items['lastname'], \PDO::PARAM_STR);
         $statement->bindValue('email', $items['email'], \PDO::PARAM_STR);
         $statement->bindValue('reservation_date', $items['date'], \PDO::PARAM_STR);
         $statement->bindValue('message', $items['message'], \PDO::PARAM_STR);
         $statement->bindValue('rate_id', $items['menu'], \PDO::PARAM_INT);
         $statement->bindValue('phone', $items['phone']);

         $statement->execute();
    }
}
