<?php
namespace Admin\DAO\File;

use Squille\Core\Collection;

class XSLSectionsFile {
    public function readByLayout($layout) {
        $fullpath = $_SERVER['DOCUMENT_ROOT']
                  . DIRECTORY_SEPARATOR . '..'
                  . DIRECTORY_SEPARATOR . 'templates'
                  . DIRECTORY_SEPARATOR . $layout
                  . DIRECTORY_SEPARATOR . 'layout.xsl';

        $dom = new \DOMDocument();
        $dom->load($fullpath);

        $xpath = new \DOMXPath($dom);
        $nl = $xpath->query('//@*[local-name()="section"
                                 and namespace-uri()="http://www.squille.com/2018/XSL/Template"]');

        $c = new Collection;
        foreach ($nl as $n) {
            $e = new \stdClass;
            $e->name = $n->value;

            if ($c->valueExists($e) === false) {
                $c->append($e);
            }
        }

        return $c;
    }
}
