<?php
namespace Application\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class PagesMenusDB extends DAODB {
    public function readByPage($page) {
        $stm = $this->connection->prepare('
			SELECT pagesmenus.* FROM pagesmenus
			
			LEFT OUTER JOIN menus
					     ON menus.id = pagesmenus.menu
						    AND menus.fixed = pagesmenus.id
			
			WHERE page = :page OR pagesmenus.id = `fixed` ORDER BY `order`');

        $stm->bindParam(':page', $page, PDO::PARAM_INT);
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }
}
