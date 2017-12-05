<?php
namespace Admin\Domain;

use Admin\DAO\DB\MenusDB;

class MenusDomain {
    public function read() {
        $dao = new MenusDB;
        return $dao->read();
    }

    public function readById($id) {
        $dao = new MenusDB;
        return $dao->readById($id);
    }

    public function deleteById($id) {
        $dao = new MenusDB;
        $dao->deleteById($id);
    }

    public function save($e) {
        $dao = new MenusDB;
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }
        return $e;
    }
}
