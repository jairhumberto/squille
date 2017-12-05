<?php
namespace Application\Domain;

use Application\DAO\DB\PagesCategoriesDB;

class PagesCategoriesDomain {
    public function readByPage($page) {
        $dao = new PagesCategoriesDB;
        return $dao->readByPage($page);
    }
}
