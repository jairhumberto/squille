<?php
namespace Application\DAO\DB;

use \PDO;

class CategoriesDB extends DAODB {
    public function readById($id) {
        $stm = $this->connection->prepare('SELECT * FROM categories WHERE id = :id');

        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchObject();
    }
}
