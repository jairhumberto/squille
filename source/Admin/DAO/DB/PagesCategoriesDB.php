<?php
namespace Admin\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class PagesCategoriesDB extends DAODB {
    public function readByCategory($category) {
        $stm = $this->connection->prepare('SELECT * FROM pagescategories WHERE category = :category ORDER BY `order`');

        $stm->bindParam(':category', $category, PDO::PARAM_INT);
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function create($e) {
        $stm = $this->connection->prepare('
				INSERT pagescategories SET
					id = :id,
                    page = :page,
					category = :category,
                    `order` = :order,
                    section = :section,
                    component = :component,
                    `limit` = :limit');

        $e->id = $this->getNextIndex();
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stm->bindParam(':page', $e->page, PDO::PARAM_INT);
        $stm->bindParam(':category', $e->category, PDO::PARAM_INT);
        $stm->bindParam(':order', $e->order, PDO::PARAM_INT);
        $stm->bindParam(':section', $e->section, PDO::PARAM_STR);
        $stm->bindParam(':component', $e->component, PDO::PARAM_STR);
        $stm->bindParam(':limit', $e->limit, PDO::PARAM_INT);

        $stm->execute();
    }

    public function update($e) {
        $stm = $this->connection->prepare('
				UPDATE pagescategories SET
					page = :page,
					category = :category,
                    `order` = :order,
                    section = :section,
                    component = :component,
                    `limit` = :limit
				WHERE
					id = :id
				');

        $stm->bindParam(':page', $e->page, PDO::PARAM_INT);
        $stm->bindParam(':category', $e->category, PDO::PARAM_INT);
        $stm->bindParam(':order', $e->order, PDO::PARAM_INT);
        $stm->bindParam(':section', $e->section, PDO::PARAM_STR);
        $stm->bindParam(':component', $e->component, PDO::PARAM_STR);
        $stm->bindParam(':limit', $e->limit, PDO::PARAM_INT);
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);

        $stm->execute();
    }

    public function deleteByCategory($category) {
        $stm = $this->connection->prepare('DELETE FROM pagescategories WHERE category = :category');
        $stm->bindParam(':category', $category, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getNextIndex() {
        $stm = $this->connection->prepare('SELECT MAX(id) max_id FROM pagescategories');
        $stm->execute();
        $e = $stm->fetchObject();
        return $e->max_id + 1;
    }
}
