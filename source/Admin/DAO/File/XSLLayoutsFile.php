<?php
namespace Admin\DAO\File;

use Squille\Core\Collection;

class XSLLayoutsFile {
    public function read() {
        $h = opendir(PUBLIC_DIR . 'xsl');
        $c = new Collection;
        while(($obj = readdir($h)) !== false) {
            if (is_dir(PUBLIC_DIR . 'xsl' . DS . $obj)
                    && file_exists(PUBLIC_DIR . 'xsl' . DS . $obj . DS . 'layout.xsl')
                    && file_exists(PUBLIC_DIR . 'xsl' . DS . $obj . DS . 'components.xsl')) {
                $e = new \stdClass;
                $e->name = $obj;
                $c->append($e);
            }
        }
        closedir($h);
        return $c;
    }
}
