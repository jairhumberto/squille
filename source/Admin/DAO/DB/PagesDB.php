<?php
namespace Admin\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class PagesDB extends DAODB {
    public function read() {
        $stm = $this->connection->prepare('SELECT * FROM pages');
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function readById($id) {
        $stm = $this->connection->prepare('SELECT * FROM pages WHERE id = :id');

        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchObject();
    }

    public function create($e) {
        $stm = $this->connection->prepare('
				INSERT pages SET
					id = :id,
                    token = :token,
					layout = :layout,
                    title = :title');

        $e->id = $this->getNextIndex();
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stm->bindParam(':token', $e->token, PDO::PARAM_STR);
        $stm->bindParam(':layout', $e->layout, PDO::PARAM_STR);
        $stm->bindParam(':title', $e->title, PDO::PARAM_STR);

        $stm->execute();
    }

    public function update($e) {
        $stm = $this->connection->prepare('
				UPDATE pages SET
					token = :token,
					layout = :layout,
                    title = :title
				WHERE
					id = :id
				');

        $stm->bindParam(':token', $e->token, PDO::PARAM_STR);
        $stm->bindParam(':layout', $e->layout, PDO::PARAM_STR);
        $stm->bindParam(':title', $e->title, PDO::PARAM_STR);
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);

        $stm->execute();
    }

    public function deleteById($id) {
        $stm = $this->connection->prepare('DELETE FROM pages WHERE id = :id');
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getNextIndex() {
        $stm = $this->connection->prepare('SELECT MAX(id) max_id FROM pages');
        $stm->execute();
        $e = $stm->fetchObject();
        return $e->max_id + 1;
    }
}
