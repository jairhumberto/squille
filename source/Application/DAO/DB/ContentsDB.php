<?php
namespace Application\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class ContentsDB extends DAODB {
	public function readByCategory($category, $limit, $offset) {
        $stm = $this->connection->prepare('SELECT * FROM contents WHERE category = :category LIMIT :limit OFFSET :offset');

        $stm->bindParam(':category', $category, PDO::PARAM_INT);
        $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stm->bindParam(':offset', $offset, PDO::PARAM_INT);
		
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function readById($id) {
        $stm = $this->connection->prepare('SELECT * FROM contents WHERE id = :id');

        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchObject();
    }
}
