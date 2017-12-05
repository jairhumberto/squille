<?php
namespace Admin\Controller;

use Admin\Domain\AuthDomain;
use Admin\Domain\LogonException;
use Squille\Core\ActionController;
use Squille\Core\Collection;

class AuthController extends ActionController {
    public function indexAction() {
        $view = $this->getViewFactory()->create('auth/layout.phtml');
        $view->addVariable('content', $this->getViewFactory()->create('auth/login.phtml'));
        $view->display();
    }

    public function logonAction(Collection $args) {
        try {
            $model = new AuthDomain;
            $model->logon($args->get('email'), $args->get('password'));

            header('Location: /admin/');
			exit;
        } catch (LogonException $e) {
            $view = $this->getViewFactory()->create('auth/layout.phtml');
            $contentView = $this->getViewFactory()->create('auth/failed-login.phtml');
            $contentView->addVariable('error', $e->getMessage());
            $view->addVariable('content', $contentView);
            $view->display();
        }
    }

    public function logoutAction() {
        $model = new AuthDomain;
        $model->logout();

        header('Location: /admin/auth');
        exit;
    }
}
