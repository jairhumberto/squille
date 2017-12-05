<?php
namespace Application\Domain;

use Application\DAO\DB\PagesMenusDB;

class PagesMenusDomain {
    public function readByPage($page) {
        $dao = new PagesMenusDB;
        return $dao->readByPage($page);
    }
}
