<?php
namespace Application\Domain;

use Application\DAO\DB\ContentsDB;

class ContentsDomain {
    public function readByCategory($category, $limit, $offset) {
        $dao = new ContentsDB;
        return $dao->readByCategory($category, $limit, $offset);
    }
	
    public function readById($id) {
        $dao = new ContentsDB;
        return $dao->readById($id);
    }
}
