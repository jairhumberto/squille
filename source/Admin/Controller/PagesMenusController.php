<?php
namespace Admin\Controller;

use Squille\Core\Collection;
use Admin\Domain\PagesMenusDomain;

class PagesMenusController extends SessionController {
	public function bindAction(Collection $args) {
		$model = new PagesMenusDomain;
		$model->deleteByMenu($args->get('menu'));
		if (is_array($args->get('id'))) {
			foreach ($args->get('id') as $key => $id) {
				$e = new \stdClass;

				$e->page = $args->get('page')[$key];
				$e->menu = $args->get('menu');
				$e->order = $args->get('order')[$key];
				$e->section = $args->get('section')[$key];
				$e->component = $args->get('component')[$key];
				$e->fixed = $args->get('fixed')[$key];

				$e = $model->save($e);
			}
	    }

		if ($args->get('save') == 'continue') {
		    header('Location: /admin/menus/edit/' . $args->get('menu'));
		} else {
		    header('Location: /admin/menus');
		}
		exit;
	}
}
