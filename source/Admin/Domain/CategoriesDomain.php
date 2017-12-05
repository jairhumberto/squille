<?php
namespace Admin\Domain;

use Admin\DAO\DB\CategoriesDB;

class CategoriesDomain {
    public function read() {
        $dao = new CategoriesDB;
        return $dao->read();
    }

    public function readById($id) {
        $dao = new CategoriesDB;
        return $dao->readById($id);
    }

    public function deleteById($id) {
        $dao = new CategoriesDB;
        $dao->deleteById($id);
    }

    public function save($e) {
        $dao = new CategoriesDB;
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }
        return $e;
    }
}
