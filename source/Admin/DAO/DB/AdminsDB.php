<?php
namespace Admin\DAO\DB;

use \PDO;

class AdminsDB extends DAODB {
    public function readByEmailAndPassword($email, $password) {
        $stm = $this->connection->prepare('SELECT * FROM admins WHERE email = :email AND password = :password');

        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $stm->bindParam(':password', $password, PDO::PARAM_STR);

        $stm->execute();
        return $stm->fetchObject();
    }
}
