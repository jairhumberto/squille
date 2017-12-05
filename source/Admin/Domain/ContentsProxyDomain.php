<?php
namespace Admin\Domain;

class ContentsProxyDomain {
    public function readCategoryById($id) {
        $model = new CategoriesDomain;
        return $model->readById($id);
    }
	
    public function readCategories() {
        $model = new CategoriesDomain;
        return $model->read();
    }

    public function readComponentByLayout($layout) {
        $model = new XSLComponentsDomain;
        return $model->readContentsByLayout($layout);
    }

    public function readContentById($id) {
        $model = new ContentsDomain;
        return $model->readById($id);
    }

    public function readContents() {
        $model = new ContentsDomain;
        return $model->read();
    }

    public function readPageById($id) {
        $model = new PagesDomain;
        return $model->readById($id);
    }
	
    public function readPages() {
        $model = new PagesDomain;
        return $model->read();
    }

    public function readPagesByContent($content) {
        $model = new PagesContentsDomain;
        return $model->readByContent($content);
    }

    public function readSectionByLayout($layout) {
        $model = new XSLSectionsDomain;
        return $model->readByLayout($layout);
    }
}
