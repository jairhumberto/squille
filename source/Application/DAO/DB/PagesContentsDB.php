<?php
namespace Application\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class PagesContentsDB extends DAODB {
    public function readByPage($page) {
        $stm = $this->connection->prepare('
				SELECT pagescontents.* FROM pagescontents
				
				INNER JOIN contents
						ON contents.id = pagescontents.content
						
				LEFT OUTER JOIN contents f
							 ON f.id = pagescontents.content
								AND f.fixed = pagescontents.id
							
				WHERE page = :page OR pagescontents.id = f.`fixed` ORDER BY pagescontents.`order`, contents.`date` DESC');

        $stm->bindParam(':page', $page, PDO::PARAM_INT);
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }
}
