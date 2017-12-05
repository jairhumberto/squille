<?php
namespace Admin\Controller;

use Squille\Core\Collection;
use Squille\Core\Route;
use Squille\Core\View;
use Admin\Domain\PagesDomain;
use Admin\Domain\PagesProxyDomain;

class PagesController extends SessionController {
	public function indexAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('pages/index.phtml');
		$contentView->addVariable('model', new PagesDomain);
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function addAction() {
	    $view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('pages/add.phtml');
		$contentView->addVariable('model', new PagesProxyDomain);
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function editAction(Collection $args, Route $route) {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('pages/edit.phtml');
		$contentView->addVariable('id', $route->getIds()->getFirst());
		$contentView->addVariable('model', new PagesProxyDomain);
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function deleteAction(Collection $args, Route $route) {
		$model = new PagesDomain;
		$model->deleteById($route->getIds()->getFirst());

		header('Location: /admin/pages');
		exit;
	}

	public function saveAction(Collection $args) {
		$e = new \stdClass;

		$e->id = $args->get('id');
		$e->token = $args->get('token');
		$e->layout = $args->get('layout');
		$e->title = $args->get('title');

		$model = new PagesDomain;
		$e = $model->save($e);

		if ($args->get('save') == 'continue') {
		    header('Location: /admin/pages/edit/' . $e->id);
		} else {
		    header('Location: /admin/pages');
		}
		exit;
	}
}
