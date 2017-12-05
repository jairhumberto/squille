<?php
namespace Admin\Domain;

class LinksProxyDomain {
    public function readLinkById($id) {
        $model = new LinksDomain;
        return $model->readById($id);
    }

    public function readLinks() {
        $model = new LinksDomain;
        return $model->read();
    }

    public function readMenuById($id) {
        $model = new MenusDomain;
        return $model->readById($id);
    }

    public function readMenus() {
        $model = new MenusDomain;
        return $model->read();
    }

    public function readPages() {
        $model = new PagesDomain;
        return $model->read();
    }
}
