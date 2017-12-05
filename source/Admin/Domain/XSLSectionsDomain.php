<?php
namespace Admin\Domain;

use Admin\DAO\File\XSLSectionsFile;

class XSLSectionsDomain {
    public function readByLayout($layout) {
        $dao = new XSLSectionsFile;
        return $dao->readByLayout($layout);
    }
}
