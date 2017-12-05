<?php
namespace Admin\Controller;

use Admin\Domain\SessionDomain;
use Admin\Domain\SessionException;
use Squille\Core\ViewFactory;
use Squille\Core\ActionController;

abstract class SessionController extends ActionController {
    public function __construct(ViewFactory $viewFactory) {
        parent::__construct($viewFactory);
        $this->autenticationAction();
    }

    private function autenticationAction() {
        try {
            $model = new SessionDomain;
            $model->autenticate();
        } catch (SessionException $e) {
            header('Location: /admin/auth');
            exit;
        }
    }
}
