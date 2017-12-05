<?php
namespace Admin\Domain;

use Admin\DAO\DB\PagesMenusDB;

class PagesMenusDomain {
    public function readByMenu($menu) {
        $dao = new PagesMenusDB;
        return $dao->readByMenu($menu);
    }

    public function deleteByMenu($menu) {
        $dao = new PagesMenusDB;
        $dao->deleteByMenu($menu);
    }

    public function save($e) {
        $dao = new PagesMenusDB;
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }
		
		$daomenus = new MenusDomain;
		$menu = $daomenus->readById($e->menu);
		if ($e->fixed) {
			$menu->fixed = $e->id;
		} else {
			$menu->fixed = null;
		}
		$daomenus->save($menu);
		
        return $e;
    }
}
