<?php
namespace Admin\Domain;

class PagesProxyDomain {
    public function readPageById($id) {
        $model = new PagesDomain;
        return $model->readById($id);
    }

    public function readXSLLayouts() {
        $model = new XSLLayoutsDomain;
        return $model->read();
    }
}
