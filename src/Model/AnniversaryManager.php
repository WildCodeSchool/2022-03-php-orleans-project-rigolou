<?php

namespace App\Model;

class AnniversaryManager extends AbstractManager
{
    public const TABLE = "anniversary_reservation";

    public function insert(array $reservation): void
    {
        $query = 'INSERT INTO ' . self::TABLE .
            ' (firstname, lastname, phone, email, reservation_date, rate_id, message, is_accepted)
         VALUES (:firstname , :lastname, :phone, :email, :reservation_date, :rate_id, :message, 0)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('firstname', $reservation['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $reservation['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('email', $reservation['email'], \PDO::PARAM_STR);
        $statement->bindValue('reservation_date', $reservation['date'], \PDO::PARAM_STR);
        $statement->bindValue('message', $reservation['message'], \PDO::PARAM_STR);
        $statement->bindValue('rate_id', $reservation['menu'], \PDO::PARAM_INT);
        $statement->bindValue('phone', $reservation['phone']);

        $statement->execute();
    }

    public function confirm($bool, $id): void
    {
        $query = 'UPDATE ' . self::TABLE . ' SET is_accepted = :bool  WHERE id = :id ;';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('bool', $bool, \PDO::PARAM_INT);
        $statement->execute();
    }
}
