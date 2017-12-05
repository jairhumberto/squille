<?php
namespace Admin\Domain;

use Admin\DAO\DB\LinksDB;

class LinksDomain {
    public function read() {
        $dao = new LinksDB;
        return $dao->read();
    }

    public function readById($id) {
        $dao = new LinksDB;
        return $dao->readById($id);
    }

    public function deleteById($id) {
        $dao = new LinksDB;
        $dao->deleteById($id);
    }

    public function save($e) {
        $dao = new LinksDB;
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }
        return $e;
    }
}
