<?php
namespace Admin\Domain;

class MenusProxyDomain {
    public function readMenuById($id) {
        $model = new MenusDomain;
        return $model->readById($id);
    }

    public function readPages() {
        $model = new PagesDomain;
        return $model->read();
    }

    public function readPagesByMenu($menu) {
        $model = new PagesMenusDomain;
        return $model->readByMenu($menu);
    }

    public function readPageById($id) {
        $model = new PagesDomain;
        return $model->readById($id);
    }

    public function readSectionByLayout($layout) {
        $model = new XSLSectionsDomain;
        return $model->readByLayout($layout);
    }

    public function readComponentByLayout($layout) {
        $model = new XSLComponentsDomain;
        return $model->readMenusByLayout($layout);
    }
}
