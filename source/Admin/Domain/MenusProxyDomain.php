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

namespace Admin\Domain;

class MenusProxyDomain
{
    public function readMenuById($id)
    {
        $model = new MenusDomain;
        return $model->readById($id);
    }

    public function readPages()
    {
        $model = new PagesDomain;
        return $model->read();
    }

    public function readPagesByMenu($menu)
    {
        $model = new PagesMenusDomain;
        return $model->readByMenu($menu);
    }

    public function readPageById($id)
    {
        $model = new PagesDomain;
        return $model->readById($id);
    }

    public function readSectionByLayout($layout)
    {
        $model = new XSLSectionsDomain;
        return $model->readByLayout($layout);
    }

    public function readComponentByLayout($layout)
    {
        $model = new XSLComponentsDomain;
        return $model->readMenusByLayout($layout);
    }
}
