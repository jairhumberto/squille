<?php
namespace Application\Domain;

use Application\DAO\DB\PagesContentsDB;

class PagesContentsDomain {
    public function readByPage($page) {
        $dao = new PagesContentsDB;
        return $dao->readByPage($page);
    }
}
