<?php
namespace Admin\Domain;

class CategoriesProxyDomain {
    public function readCategoryById($id) {
        $model = new CategoriesDomain;
        return $model->readById($id);
    }

    public function readPages() {
        $model = new PagesDomain;
        return $model->read();
    }

    public function readPagesByCategory($category) {
        $model = new PagesCategoriesDomain;
        return $model->readByCategory($category);
    }

    public function readPageById($id) {
        $model = new PagesDomain;
        return $model->readById($id);
    }

    public function readSectionByLayout($layout) {
        $model = new XSLSectionsDomain;
        return $model->readByLayout($layout);
    }

 // public function readCategoriesByLayout($layout) {
    // public function readXSLComponents() {
        // $model = new XSLComponentsDomain;
     // // return $model->readCategoriesByLayout($layout);
        // return $model->readCategories();
    // }
}
