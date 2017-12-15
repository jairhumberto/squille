<?php
/**
 * Squille https://github.com/jairhumberto/Squille
 *
 * MIT License
 *
 * Copyright c 2017 Jair Humberto
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files the "Software", to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Application\Controller;

use Squille\Core\ActionController;
use Squille\Core\Collection;
use Squille\Core\View;
use Application\Domain\PagesProxyDomain;

class IndexController extends ActionController
{
    public function indexAction(Collection $args)
    {
        $view = $this->getViewFactory()->create('index/page.xml');

        $model = new PagesProxyDomain;
        $view->addVariable('model', $model);

        $page = $model->readPageByToken($args->get('path'));
        $view->addVariable('page', $page);
        $view->addVariable('offset', $args->get('offset'));

        // Here for debug reasons.
        // header('Content-type: text/xml');
        // $view->display();die;

        $content = $this->getDisplayContent($view);

        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->loadXML($content);

        $xsl = new \DOMDocument('1.0', 'UTF-8');
        $xsl->load($_SERVER['DOCUMENT_ROOT']
                 . DIRECTORY_SEPARATOR . '..'
                 . DIRECTORY_SEPARATOR . 'templates'
                 . DIRECTORY_SEPARATOR . $page->layout
                 . DIRECTORY_SEPARATOR . 'layout.xsl');

        $proc = new \XSLTProcessor;
        $proc->importStyleSheet($xsl);

        $xml2 = $proc->transformToDoc($xml);

        $xsl2 = new \DOMDocument('1.0', 'UTF-8');
        $xsl2->load($_SERVER['DOCUMENT_ROOT']
                  . DIRECTORY_SEPARATOR . '..'
                  . DIRECTORY_SEPARATOR . 'templates'
                  . DIRECTORY_SEPARATOR . $page->layout
                  . DIRECTORY_SEPARATOR . 'components.xsl');

        $proc2 = new \XSLTProcessor();
        $proc2->importStylesheet($xsl2);

        echo $proc2->transformToXml($xml2);
    }

    public function getDisplayContent($view)
    {
        ob_start();
        $view->display();
        $displaycontent = ob_get_contents();
        ob_clean();

        return $displaycontent;
    }
}
