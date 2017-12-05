<?php
namespace Application\Domain;

use Application\DAO\DB\PagesDB;

class PagesDomain {
    public function readByToken($token) {
        $dao = new PagesDB;
        return $dao->readByToken($token);
    }
}
