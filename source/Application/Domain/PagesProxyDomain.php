<?php
namespace Application\Domain;

class PagesProxyDomain {
    public function readCategoryById($id) {
        $model = new CategoriesDomain;
        return $model->readById($id);
    }
	
    public function readCategoryContents($category, $limit, $offset) {
        $model = new ContentsDomain;
        return $model->readByCategory($category, $limit, $offset);
    }
	
    public function readContentById($id) {
        $model = new ContentsDomain;
        return $model->readById($id);
    }
	
    public function readPageByToken($token) {
        $model = new PagesDomain;
        return $model->readByToken($token);
    }

    public function readPageCategories($page) {
        $model = new PagesCategoriesDomain;
        return $model->readByPage($page);
    }
	
    public function readPageContents($page) {
        $model = new PagesContentsDomain;
        return $model->readByPage($page);
    }
    
	public function readPageMenus($page) {
        $model = new PagesMenusDomain;
        return $model->readByPage($page);
    }

    public function readMenuLinks($menu) {
        $model = new LinksDomain;
        return $model->readByMenu($menu);
    }

    public function readMenuById($id) {
        $model = new MenusDomain;
        return $model->readById($id);
    }
}
