<?php
namespace Admin\Controller;

use Admin\Domain\CategoriesDomain;
use Admin\Domain\CategoriesProxyDomain;
use Squille\Core\Collection;
use Squille\Core\Route;
use Squille\Core\View;

class CategoriesController extends SessionController {
	public function indexAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('categories/index.phtml');
		$contentView->addVariable('model', new CategoriesDomain());
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function addAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');
		$view->addVariable('content', $this->getViewFactory()->create('categories/add.phtml'));
		$view->display();
	}

	public function editAction(Collection $args, Route $route) {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('categories/edit.phtml');
		$contentView->addVariable('id', $route->getIds()->getFirst());
		$contentView->addVariable('model', new CategoriesProxyDomain());
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function deleteAction(Collection $args, Route $route) {
		$model = new CategoriesDomain;
		$model->deleteById($route->getIds()->getFirst());

		header('Location: /admin/categories');
		exit;
	}

	public function saveAction(Collection $args) {
		$e = new \stdClass;

		$e->id = $args->get('id');
		$e->description = $args->get('description');

		$model = new CategoriesDomain;
		$e = $model->save($e);

		if ($args->get('save') == 'continue') {
		    header('Location: /admin/categories/edit/' . $e->id);
		} else {
		    header('Location: /admin/categories');
		}
		exit;
	}
}
