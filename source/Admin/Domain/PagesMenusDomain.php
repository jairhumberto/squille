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

use Admin\DAO\DB\PagesMenusDB;

class PagesMenusDomain
{
    public function readByMenu($menu)
    {
        $dao = new PagesMenusDB;
        return $dao->readByMenu($menu);
    }

    public function deleteByMenu($menu)
    {
        $dao = new PagesMenusDB;
        $dao->deleteByMenu($menu);
    }

    public function save($e)
    {
        $dao = new PagesMenusDB;
        if ($e->id) {
            $dao->update($e);
        } else {
            $dao->create($e);
        }

        $daomenus = new MenusDomain;
        $menu = $daomenus->readById($e->menu);
        if ($e->fixed) {
            $menu->fixed = $e->id;
        } else {
            $menu->fixed = null;
        }
        $daomenus->save($menu);

        return $e;
    }
}
