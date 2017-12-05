<?php
namespace Admin\Controller;

use Squille\Core\Collection;
use Squille\Core\Route;
use Squille\Core\View;
use Admin\Domain\LinksDomain;
use Admin\Domain\LinksProxyDomain;

class LinksController extends SessionController {
	public function indexAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('links/index.phtml');
		$contentView->addVariable('model', new LinksProxyDomain());
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function addAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');
		
		$contentView = $this->getViewFactory()->create('links/add.phtml');
		$contentView->addVariable('model', new LinksProxyDomain());
		$view->addVariable('content', $contentView);
		
		$view->display();
	}

	public function editAction(Collection $args, Route $route) {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('links/edit.phtml');
		$contentView->addVariable('id', $route->getIds()->getFirst());
		$contentView->addVariable('model', new LinksProxyDomain());
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function deleteAction(Collection $args, Route $route) {
		$model = new LinksDomain;
		$model->deleteById($route->getIds()->getFirst());

		header('Location: /admin/links');
		exit;
	}

	public function saveAction(Collection $args) {
		$e = new \stdClass;

		$e->id = $args->get('id');
		$e->menu = $args->get('menu');
		$e->tipo = $args->get('tipo');
		$e->href = $args->get('href');
		$e->text = $args->get('text');

		$model = new LinksDomain;
		$e = $model->save($e);

		if ($args->get('save') == 'continue') {
		    header('Location: /admin/links/edit/' . $e->id);
		} else {
		    header('Location: /admin/links');
		}
		exit;
	}
}
