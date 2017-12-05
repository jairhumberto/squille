<?php
namespace Application\Domain;

use Application\DAO\DB\MenusDB;

class MenusDomain {
    public function readById($id) {
        $dao = new MenusDB;
        return $dao->readById($id);
    }
}
