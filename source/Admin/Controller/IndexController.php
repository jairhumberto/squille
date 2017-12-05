<?php
namespace Admin\Controller;

use Squille\Core\View;

class IndexController extends SessionController {
    public function indexAction() {
        $view = $this->getViewFactory()->create('index/layout.phtml');
        $view->addVariable('content', new View('Admin', 'index/index.phtml'));
        $view->display();
    }
}
