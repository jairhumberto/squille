<?php
namespace Admin\DAO\File;

use Squille\Core\Collection;

class XSLSectionsFile {
    public function readByLayout($layout) {
        $fullpath = PUBLIC_DIR . 'xsl' . DS . $layout . DS . 'layout.xsl';
        $dom = new \DOMDocument();
        $dom->load($fullpath);

        $xpath = new \DOMXPath($dom);
        $nl = $xpath->query('//@*[local-name()="section"
                                 and namespace-uri()="http://www.squille.com/2018/XSL/Template"]');

        $c = new Collection;
        foreach ($nl as $n) {
            $e = new \stdClass;
            $e->name = $n->value;
            $c->append($e);
        }
        return $c;
    }
}
