<?php
namespace Application\Domain;

use Application\DAO\DB\LinksDB;

class LinksDomain {
    public function readByMenu($menu) {
        $dao = new LinksDB;
        return $dao->readByMenu($menu);
    }
}
