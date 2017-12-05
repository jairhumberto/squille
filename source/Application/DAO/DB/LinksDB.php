<?php
namespace Application\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class LinksDB extends DAODB {
    public function readByMenu($menu) {
        $stm = $this->connection->prepare('SELECT * FROM links WHERE menu = :menu');

        $stm->bindParam(':menu', $menu, PDO::PARAM_INT);
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }
}
