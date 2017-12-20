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
use Admin\Domain\PagesDomain;
use Admin\Domain\PagesCategoriesDomain;

class PagesCategoriesController extends SessionController
{
    public function bindAction(Collection $args)
    {
        $model = new PagesCategoriesDomain;

        $e = new \stdClass;

        $e->page = $args->get('todas') ? null : $args->get('page');
        $e->category = $args->get('category');
        $e->order = $args->get('order');
        $e->section = $args->get('section');
        $e->component = $args->get('component');
        $e->limit = $args->get('limit') ? $args->get('limit') : null;

        $e = $model->save($e);
        
        $pagemodel = new PagesDomain;
        $e->page = $pagemodel->readById($e->page)->title;
        
        header('Content-type: text/json');
        echo json_encode($e);
        exit;
    }
    
    public function unbindAction(Collection $args, Route $route)
    {
        $id = $route->getIds()->getFirst();
        $model = new PagesCategoriesDomain;
        $model->deleteById($id);
    }
}
