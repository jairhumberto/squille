<?php
namespace Admin\DAO\File;

use Squille\Core\Collection;

class XSLComponentsFile {
    public function readContentsByLayout($layout) {
        $fullpath = $_SERVER['DOCUMENT_ROOT']
                  . DIRECTORY_SEPARATOR . '..'
                  . DIRECTORY_SEPARATOR . 'templates'
                  . DIRECTORY_SEPARATOR . $layout
                  . DIRECTORY_SEPARATOR . 'components.xsl';

        $dom = new \DOMDocument();
        $dom->load($fullpath);

        $xpath = new \DOMXPath($dom);
        $nl = $xpath->query('//@*[local-name()="content"
                                 and namespace-uri()="http://www.squille.com/2018/XSL/Template"]');

        $c = new Collection;
        foreach($nl as $n) {
            $e = new \stdClass;
            $e->name = $n->value;
            $c->append($e);
        }
        return $c;
    }
	
    public function readCategoriesByLayout($layout) {
        $fullpath = $_SERVER['DOCUMENT_ROOT']
                  . DIRECTORY_SEPARATOR . '..'
                  . DIRECTORY_SEPARATOR . 'templates'
                  . DIRECTORY_SEPARATOR . $layout
                  . DIRECTORY_SEPARATOR . 'components.xsl';

        $dom = new \DOMDocument();
        $dom->load($fullpath);

        $xpath = new \DOMXPath($dom);
        $nl = $xpath->query('//@*[local-name()="category"
                                 and namespace-uri()="http://www.squille.com/2018/XSL/Template"]');

        $c = new Collection;
        foreach($nl as $n) {
            $e = new \stdClass;
            $e->name = $n->value;
            $c->append($e);
        }
        return $c;
    }

    public function readMenusByLayout($layout) {
        $fullpath = $_SERVER['DOCUMENT_ROOT']
                  . DIRECTORY_SEPARATOR . '..'
                  . DIRECTORY_SEPARATOR . 'templates'
                  . DIRECTORY_SEPARATOR . $layout
                  . DIRECTORY_SEPARATOR . 'components.xsl';

        $dom = new \DOMDocument();
        $dom->load($fullpath);

        $xpath = new \DOMXPath($dom);
        $nl = $xpath->query('//@*[local-name()="menu"
                                 and namespace-uri()="http://www.squille.com/2018/XSL/Template"]');

        $c = new Collection;
        foreach($nl as $n) {
            $e = new \stdClass;
            $e->name = $n->value;
            $c->append($e);
        }
        return $c;
    }
}
