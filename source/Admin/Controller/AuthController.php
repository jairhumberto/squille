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

use Admin\Domain\AuthDomain;
use Admin\Domain\LogonException;
use Squille\Core\ActionController;
use Squille\Core\Collection;

class AuthController extends ActionController
{
    public function indexAction()
    {
        $view = $this->getViewFactory()->create('auth/layout.phtml');
        $view->addVariable('content', $this->getViewFactory()->create('auth/login.phtml'));
        $view->display();
    }

    public function logonAction(Collection $args)
    {
        try {
            $model = new AuthDomain;
            $model->logon($args->get('email'), $args->get('password'));

            header('Location: /admin/');
            exit;
        } catch (LogonException $e) {
            $view = $this->getViewFactory()->create('auth/layout.phtml');
            $contentView = $this->getViewFactory()->create('auth/failed-login.phtml');
            $contentView->addVariable('error', $e->getMessage());
            $view->addVariable('content', $contentView);
            $view->display();
        }
    }

    public function logoutAction()
    {
        $model = new AuthDomain;
        $model->logout();

        header('Location: /admin/auth');
        exit;
    }
}
