<?php
namespace Admin\Domain;

use Admin\DAO\File\XSLComponentsFile;

class XSLComponentsDomain {
    public function readContentsByLayout($layout) {
        $dao = new XSLComponentsFile;
        return $dao->readContentsByLayout($layout);
    }

    public function readCategoriesByLayout($layout) {
        $dao = new XSLComponentsFile;
        return $dao->readCategoriesByLayout($layout);
    }

    public function readMenusByLayout($layout) {
        $dao = new XSLComponentsFile;
        return $dao->readMenusByLayout($layout);
    }
}
