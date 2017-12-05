<?php
namespace Admin\Domain;

use Admin\DAO\DB\PagesDB;

class PagesDomain {
    public function read() {
        $dao = new PagesDB;
        return $dao->read();
    }

    public function readById($id) {
        $dao = new PagesDB;
        return $dao->readById($id);
    }

    public function deleteById($id) {
        $dao = new PagesDB;
        $dao->deleteById($id);
    }

    public function save($e) {
        $dao = new PagesDB;
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }
        return $e;
    }
}
