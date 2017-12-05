<?php
namespace Admin\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class CategoriesDB extends DAODB {
    public function read() {
        $stm = $this->connection->prepare('SELECT * FROM categories');
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function readById($id) {
        $stm = $this->connection->prepare('SELECT * FROM categories WHERE id = :id');

        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchObject();
    }

    public function create($e) {
        $stm = $this->connection->prepare('
				INSERT categories SET
					id = :id,
                    description = :description,
					fixed = :fixed');

        $e->id = $this->getNextIndex();
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stm->bindParam(':description', $e->description, PDO::PARAM_STR);
        $stm->bindParam(':fixed', $e->fixed, PDO::PARAM_INT);

        $stm->execute();
    }

    public function update($e) {
        $stm = $this->connection->prepare('
				UPDATE categories SET
					description = :description,
					fixed = :fixed
				WHERE
					id = :id
				');

        $stm->bindParam(':description', $e->description, PDO::PARAM_STR);
		$stm->bindParam(':fixed', $e->fixed, PDO::PARAM_INT);
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);

        $stm->execute();
    }

    public function deleteById($id) {
        $stm = $this->connection->prepare('DELETE FROM categories WHERE id = :id');
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getNextIndex() {
        $stm = $this->connection->prepare('SELECT MAX(id) max_id FROM categories');
        $stm->execute();
        $e = $stm->fetchObject();
        return $e->max_id + 1;
    }
}
