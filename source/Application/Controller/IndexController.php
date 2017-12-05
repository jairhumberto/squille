<?php
namespace Application\Controller;

use Squille\Core\ActionController;
use Squille\Core\Collection;
use Squille\Core\View;
use Application\Domain\PagesProxyDomain;

class IndexController extends ActionController {
    public function indexAction(Collection $args) {
        $view = $this->getViewFactory()->create('index/page.xml');

        $model = new PagesProxyDomain;
        $view->addVariable('model', $model);

        $page = $model->readPageByToken($args->get('path'));
        $view->addVariable('page', $page);
        $view->addVariable('offset', $args->get('offset'));
		
		//header('Content-type: text/xml');
		//$view->display();die;
		
        $content = $this->getDisplayContent($view);

        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->loadXML($content);

        $xsl = new \DOMDocument('1.0', 'UTF-8');
        $xsl->load(PUBLIC_DIR . 'xsl' . DS . $page->layout . DS . 'layout.xsl');

        $proc = new \XSLTProcessor;
        $proc->importStyleSheet($xsl);

        $xml2 = $proc->transformToDoc($xml);

        $xsl2 = new \DOMDocument('1.0', 'UTF-8');
        $xsl2->load(PUBLIC_DIR . 'xsl' . DS . $page->layout . DS . 'components.xsl');

        $proc2 = new \XSLTProcessor();
        $proc2->importStylesheet($xsl2);

        echo $proc2->transformToXml($xml2);
    }

    public function getDisplayContent($view) {
        ob_start();
        $view->display();
        $displaycontent = ob_get_contents();
        ob_clean();

        return $displaycontent;
    }
}
