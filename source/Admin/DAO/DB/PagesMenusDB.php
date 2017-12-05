<?php
namespace Admin\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class PagesMenusDB extends DAODB {
    public function readByMenu($menu) {
        $stm = $this->connection->prepare('SELECT * FROM pagesmenus WHERE menu = :menu ORDER BY `order`');

        $stm->bindParam(':menu', $menu, PDO::PARAM_INT);
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function create($e) {
        $stm = $this->connection->prepare('
				INSERT pagesmenus SET
					id = :id,
                    page = :page,
					menu = :menu,
                    `order` = :order,
                    section = :section,
                    component = :component');

        $e->id = $this->getNextIndex();
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stm->bindParam(':page', $e->page, PDO::PARAM_INT);
        $stm->bindParam(':menu', $e->menu, PDO::PARAM_INT);
        $stm->bindParam(':order', $e->order, PDO::PARAM_INT);
        $stm->bindParam(':section', $e->section, PDO::PARAM_STR);
        $stm->bindParam(':component', $e->component, PDO::PARAM_STR);

        $stm->execute();
    }

    public function update($e) {
        $stm = $this->connection->prepare('
				UPDATE pagesmenus SET
					page = :page,
					menu = :menu,
                    `order` = :order,
                    section = :section,
                    component = :component
				WHERE
					id = :id
				');

        $stm->bindParam(':page', $e->page, PDO::PARAM_INT);
        $stm->bindParam(':menu', $e->menu, PDO::PARAM_INT);
        $stm->bindParam(':order', $e->order, PDO::PARAM_INT);
        $stm->bindParam(':section', $e->section, PDO::PARAM_STR);
        $stm->bindParam(':component', $e->component, PDO::PARAM_STR);
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);

        $stm->execute();
    }

    public function deleteByMenu($menu) {
        $stm = $this->connection->prepare('DELETE FROM pagesmenus WHERE menu = :menu');
        $stm->bindParam(':menu', $menu, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getNextIndex() {
        $stm = $this->connection->prepare('SELECT MAX(id) max_id FROM pagesmenus');
        $stm->execute();
        $e = $stm->fetchObject();
        return $e->max_id + 1;
    }
}
