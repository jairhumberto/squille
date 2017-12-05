<?php
namespace Admin\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class PagesContentsDB extends DAODB {
    public function readByContent($content) {
        $stm = $this->connection->prepare('SELECT * FROM pagescontents WHERE content = :content ORDER BY `order`');

        $stm->bindParam(':content', $content, PDO::PARAM_INT);
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function create($e) {
        $stm = $this->connection->prepare('
				INSERT pagescontents SET
					id = :id,
                    page = :page,
					content = :content,
                    `order` = :order,
                    section = :section,
                    component = :component');

        $e->id = $this->getNextIndex();
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stm->bindParam(':page', $e->page, PDO::PARAM_INT);
        $stm->bindParam(':content', $e->content, PDO::PARAM_INT);
        $stm->bindParam(':order', $e->order, PDO::PARAM_INT);
        $stm->bindParam(':section', $e->section, PDO::PARAM_STR);
        $stm->bindParam(':component', $e->component, PDO::PARAM_STR);

        $stm->execute();
    }

    public function update($e) {
        $stm = $this->connection->prepare('
				UPDATE pagescontents SET
					page = :page,
					content = :content,
                    `order` = :order,
                    section = :section,
                    component = :component
				WHERE
					id = :id
				');

        $stm->bindParam(':page', $e->page, PDO::PARAM_INT);
        $stm->bindParam(':content', $e->content, PDO::PARAM_INT);
        $stm->bindParam(':order', $e->order, PDO::PARAM_INT);
        $stm->bindParam(':section', $e->section, PDO::PARAM_STR);
        $stm->bindParam(':component', $e->component, PDO::PARAM_STR);
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);

        $stm->execute();
    }

    public function deleteByContent($content) {
        $stm = $this->connection->prepare('DELETE FROM pagescontents WHERE content = :content');
        $stm->bindParam(':content', $content, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getNextIndex() {
        $stm = $this->connection->prepare('SELECT MAX(id) max_id FROM pagescontents');
        $stm->execute();
        $e = $stm->fetchObject();
        return $e->max_id + 1;
    }
}
