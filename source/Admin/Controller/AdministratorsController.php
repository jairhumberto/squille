<?php
/**
 * Squille (https://github.com/jairhumberto/Squille)
 *
 * MIT License
 *
 * Copyright (c) 2017 Jair Humberto
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Admin\Controller;

use Squille\Core\Collection;
use Squille\Core\Route;
use Squille\Core\View;
use Admin\Domain\AdministratorsDomain;

class AdministratorsController extends SessionController
{
    public function indexAction()
    {
        $view = $this->getViewFactory()->create('index/layout.phtml');

        $contentView = $this->getViewFactory()->create('administrators/index.phtml');
        $contentView->addVariable('model', new AdministratorsDomain);
        $view->addVariable('content', $contentView);

        $view->display();
    }

    public function addAction()
    {
        $view = $this->getViewFactory()->create('index/layout.phtml');

        $contentView = $this->getViewFactory()->create('administrators/add.phtml');
        $contentView->addVariable('model', new AdministratorsDomain);
        $view->addVariable('content', $contentView);

        $view->display();
    }

    public function editAction(Collection $args, Route $route)
    {
        $view = $this->getViewFactory()->create('index/layout.phtml');

        $contentView = $this->getViewFactory()->create('administrators/edit.phtml');
        $contentView->addVariable('id', $route->getIds()->getFirst());
        $contentView->addVariable('model', new AdministratorsDomain);
        $view->addVariable('content', $contentView);

        $view->display();
    }

    public function deleteAction(Collection $args, Route $route)
    {
        $model = new AdministratorsDomain;
        $model->deleteById($route->getIds()->getFirst());

        header('Location: /admin/administrators');
        exit;
    }

    public function saveAction(Collection $args)
    {
        $e = new \stdClass;

        $e->id = $args->get('id');
        $e->name = $args->get('name');
        $e->email = $args->get('email');
        $e->password = $args->get('password');
        $e->avatar = base64_encode(file_get_contents($args->get('avatar')['tmp_name']));
        
        $model = new AdministratorsDomain;
        $e = $model->save($e);

        if ($args->get('save') == 'continue') {
            header('Location: /admin/administrators/edit/' . $e->id);
        } else {
            header('Location: /admin/administrators');
        }

        exit;
    }
}
