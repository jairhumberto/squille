<?php
namespace Application\Domain;

use Application\DAO\DB\CategoriesDB;

class CategoriesDomain {
    public function readById($id) {
        $dao = new CategoriesDB;
        return $dao->readById($id);
    }
}
