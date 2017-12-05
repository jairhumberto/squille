<?php
namespace Admin\Domain;

use Admin\DAO\File\XSLLayoutsFile;

class XSLLayoutsDomain {
    public function read() {
        $dao = new XSLLayoutsFile;
        return $dao->read();
    }
}
