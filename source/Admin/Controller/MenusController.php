<?php
namespace Admin\Controller;

use Squille\Core\Collection;
use Squille\Core\Route;
use Squille\Core\View;
use Admin\Domain\MenusDomain;
use Admin\Domain\MenusProxyDomain;

class MenusController extends SessionController {
	public function indexAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('menus/index.phtml');
		$contentView->addVariable('model', new MenusDomain());
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function addAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');
		$view->addVariable('content', $this->getViewFactory()->create('menus/add.phtml'));
		$view->display();
	}

	public function editAction(Collection $args, Route $route) {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('menus/edit.phtml');
		$contentView->addVariable('id', $route->getIds()->getFirst());
		$contentView->addVariable('model', new MenusProxyDomain());
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function deleteAction(Collection $args, Route $route) {
		$model = new MenusDomain;
		$model->deleteById($route->getIds()->getFirst());

		header('Location: /admin/menus');
		exit;
	}

	public function saveAction(Collection $args) {
		$e = new \stdClass;

		$e->id = $args->get('id');
		$e->description = $args->get('description');

		$model = new MenusDomain;
		$e = $model->save($e);

		if ($args->get('save') == 'continue') {
		    header('Location: /admin/menus/edit/' . $e->id);
		} else {
		    header('Location: /admin/menus');
		}
		exit;
	}
}
