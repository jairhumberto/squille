<?php
namespace Admin\Domain;

use Admin\DAO\DB\PagesContentsDB;

class PagesContentsDomain {
    public function readByContent($content) {
        $dao = new PagesContentsDB;
        return $dao->readByContent($content);
    }

    public function deleteByContent($content) {
        $dao = new PagesContentsDB;
        $dao->deleteByContent($content);
    }

    public function save($e) {
        $dao = new PagesContentsDB;
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }
		
		$daocontents = new ContentsDomain;
		$content = $daocontents->readById($e->content);
		if ($e->fixed) {
			$content->fixed = $e->id;
		} else {
			$content->fixed = null;
		}
		$daocontents->save($content);
		
        return $e;
    }
}
