<?php
namespace Admin\Controller;

use Squille\Core\Collection;
use Squille\Core\Route;
use Squille\Core\View;
use Admin\Domain\FilesDomain;
use Admin\Domain\DataException;

class FilesController extends SessionController {
	public function indexAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('files/index.phtml');
		$contentView->addVariable('urlinicial', '/');
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function uploadAction() {
		try {
			$model = new FilesDomain;
			$model->upload();
			
			$view = $this->getViewFactory()->create('index/layout.phtml');

			$contentView = $this->getViewFactory()->create('files/index.phtml');
			$contentView->addVariable('urlinicial', ($_POST['navurl'] ? $_POST['navurl'] : '/'));
			$view->addVariable('content', $contentView);

			$view->display();
		} catch(DataException $e) {
			$view = $this->getViewFactory()->create('index/layout.phtml');

			$contentView = $this->getViewFactory()->create('files/index.phtml');
			$contentView->addVariable('urlinicial', $_POST['navurl']);
			$contentView->addVariable('erros', $e->getMessage());
			$view->addVariable('content', $contentView);

			$view->display();
		}
	}
}
