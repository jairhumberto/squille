<?php
namespace Application\DAO\DB;

use \PDO;

class PagesDB extends DAODB {
    public function readByToken($token) {
        $stm = $this->connection->prepare('SELECT * FROM pages WHERE token = :token');

        $stm->bindParam(':token', $token, PDO::PARAM_STR);
        $stm->execute();

        return $stm->fetchObject();
    }
}
