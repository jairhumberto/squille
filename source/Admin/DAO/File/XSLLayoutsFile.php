<?php
namespace Admin\DAO\File;

use Squille\Core\Collection;

class XSLLayoutsFile {
    public function read() {
        $templatedir = realpath($_SERVER['DOCUMENT_ROOT']
                              . DIRECTORY_SEPARATOR . '..'
                              . DIRECTORY_SEPARATOR . 'templates');

        $h = opendir($templatedir);

        $c = new Collection;
        while(($obj = readdir($h)) !== false) {
            if (is_dir($templatedir . DIRECTORY_SEPARATOR . $obj)
                    && file_exists($templatedir . DIRECTORY_SEPARATOR . $obj . DIRECTORY_SEPARATOR . 'layout.xsl')
                    && file_exists($templatedir . DIRECTORY_SEPARATOR . $obj . DIRECTORY_SEPARATOR . 'components.xsl')) {
                $e = new \stdClass;
                $e->name = $obj;
                $c->append($e);
            }
        }
        closedir($h);
        return $c;
    }
}
