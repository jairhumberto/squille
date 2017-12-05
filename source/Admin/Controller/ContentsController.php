<?php
namespace Admin\Controller;

use Squille\Core\Collection;
use Squille\Core\Route;
use Squille\Core\View;
use Admin\Domain\ContentsDomain;
use Admin\Domain\ContentsProxyDomain;

class ContentsController extends SessionController {
	public function indexAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('contents/index.phtml');
		$contentView->addVariable('model', new ContentsProxyDomain());
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function addAction() {
		$view = $this->getViewFactory()->create('index/layout.phtml');
		
		$contentView = $this->getViewFactory()->create('contents/add.phtml');
		$contentView->addVariable('model', new ContentsProxyDomain());
		$view->addVariable('content', $contentView);
		
		$view->display();
	}

	public function editAction(Collection $args, Route $route) {
		$view = $this->getViewFactory()->create('index/layout.phtml');

		$contentView = $this->getViewFactory()->create('contents/edit.phtml');
		$contentView->addVariable('id', $route->getIds()->getFirst());
		$contentView->addVariable('model', new ContentsProxyDomain());
		$view->addVariable('content', $contentView);

		$view->display();
	}

	public function deleteAction(Collection $args, Route $route) {
		$model = new ContentsDomain;
		$model->deleteById($route->getIds()->getFirst());

		header('Location: /admin/contents');
		exit;
	}

	public function saveAction(Collection $args) {
		$e = new \stdClass;

		$e->id = $args->get('id');
		$e->category = $args->get('category');
		$e->description = $args->get('description');
		$e->date = $args->get('date');
		$e->text = $args->get('text');

		$model = new ContentsDomain;
		$e = $model->save($e);

		if ($args->get('save') == 'continue') {
		    header('Location: /admin/contents/edit/' . $e->id);
		} else {
		    header('Location: /admin/contents');
		}
		
		exit;
	}
}
