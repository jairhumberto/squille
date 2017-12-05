<?php
namespace Admin\Controller;

use Squille\Core\Collection;
use Admin\Domain\PagesContentsDomain;

class PagesContentsController extends SessionController {
	public function bindAction(Collection $args) {
	    header('Content-type:text/plain');
		$model = new PagesContentsDomain;
		$model->deleteByContent($args->get('content'));

		if (is_array($args->get('id'))) {
			foreach ($args->get('id') as $key => $id) {
				$e = new \stdClass;

				$e->page = $args->get('page')[$key];
				$e->content = $args->get('content');
				$e->order = $args->get('order')[$key];
				$e->section = $args->get('section')[$key];
				$e->component = $args->get('component')[$key];
				$e->fixed = $args->get('fixed')[$key];

				$e = $model->save($e);
			}
	    }

		if ($args->get('save') == 'continue') {
		    header('Location: /admin/contents/edit/' . $args->get('content'));
		} else {
		    header('Location: /admin/contents');
		}
		exit;
	}
}
