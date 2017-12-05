<?php
namespace Admin\Controller;

use Squille\Core\Collection;
use Admin\Domain\PagesCategoriesDomain;

class PagesCategoriesController extends SessionController {
	public function bindAction(Collection $args) {
		$model = new PagesCategoriesDomain;
		$model->deleteByCategory($args->get('category'));
		
		if (is_array($args->get('id'))) {
			foreach ($args->get('id') as $key => $id) {
				$e = new \stdClass;

				$e->page = $args->get('page')[$key];
				$e->category = $args->get('category');
				$e->order = $args->get('order')[$key];
				$e->section = $args->get('section')[$key];
				$e->component = $args->get('component')[$key];
				$e->limit = $args->get('limit')[$key];
				$e->fixed = $args->get('fixed')[$key];

				$e = $model->save($e);
			}
	    }

		if ($args->get('save') == 'continue') {
		    header('Location: /admin/categories/edit/' . $args->get('category'));
		} else {
		    header('Location: /admin/categories');
		}
		exit;
	}
}
