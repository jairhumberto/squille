<?php
namespace Admin\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class LinksDB extends DAODB {
    public function read() {
        $stm = $this->connection->prepare('SELECT * FROM links');
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function readById($id) {
        $stm = $this->connection->prepare('SELECT * FROM links WHERE id = :id');

        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchObject();
    }

    public function create($e) {
        $stm = $this->connection->prepare('
				INSERT links SET
					id = :id,
					menu = :menu,
                    tipo = :tipo,
                    href = :href,
					text = :text');

        $e->id = $this->getNextIndex();
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stm->bindParam(':menu', $e->menu, PDO::PARAM_INT);
        $stm->bindParam(':tipo', $e->tipo, PDO::PARAM_STR);
        $stm->bindParam(':href', $e->href, PDO::PARAM_STR);
        $stm->bindParam(':text', $e->text, PDO::PARAM_STR);

        $stm->execute();
    }

    public function update($e) {
        $stm = $this->connection->prepare('
				UPDATE links SET
					menu = :menu,
					tipo = :tipo,
					href = :href,
					text = :text
				WHERE
					id = :id
				');

        $stm->bindParam(':menu', $e->menu, PDO::PARAM_INT);
        $stm->bindParam(':tipo', $e->tipo, PDO::PARAM_STR);
        $stm->bindParam(':href', $e->href, PDO::PARAM_STR);
        $stm->bindParam(':text', $e->text, PDO::PARAM_STR);
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);

        $stm->execute();
    }

    public function deleteById($id) {
        $stm = $this->connection->prepare('DELETE FROM links WHERE id = :id');
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getNextIndex() {
        $stm = $this->connection->prepare('SELECT MAX(id) max_id FROM links');
        $stm->execute();
        $e = $stm->fetchObject();
        return $e->max_id + 1;
    }
}
