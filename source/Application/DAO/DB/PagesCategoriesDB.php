<?php
namespace Application\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class PagesCategoriesDB extends DAODB {
    public function readByPage($page) {
        $stm = $this->connection->prepare('
			SELECT pagescategories.* FROM pagescategories
			
			LEFT OUTER JOIN categories
					     ON categories.id = pagescategories.category
						    AND categories.fixed = pagescategories.id

			WHERE page = :page OR pagescategories.id = `fixed` ORDER BY `order`');

        $stm->bindParam(':page', $page, PDO::PARAM_INT);
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }
}
