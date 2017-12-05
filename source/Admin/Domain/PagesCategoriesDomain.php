<?php
namespace Admin\Domain;

use Admin\DAO\DB\PagesCategoriesDB;

class PagesCategoriesDomain {
    public function readByCategory($category) {
        $dao = new PagesCategoriesDB;
        return $dao->readByCategory($category);
    }

    public function deleteByCategory($category) {
        $dao = new PagesCategoriesDB;
        $dao->deleteByCategory($category);
    }

    public function save($e) {
        $dao = new PagesCategoriesDB;
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }
		
		$daocategories = new CategoriesDomain;
		$category = $daocategories->readById($e->category);
		if ($e->fixed) {
			$category->fixed = $e->id;
		} else {
			$category->fixed = null;
		}
		$daocategories->save($category);
		
        return $e;
    }
}
