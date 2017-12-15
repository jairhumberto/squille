<?php
/**
 * Squille https://github.com/jairhumberto/Squille
 *
 * MIT License
 *
 * Copyright c 2017 Jair Humberto
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files the "Software", to deal
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

namespace Application\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class PagesCategoriesDB extends DAODB
{
    public function readByPage($page)
    {
        $stm = $this->connection->prepare('
            SELECT pagescategories.* FROM pagescategories

            LEFT OUTER JOIN categories
                         ON categories.id = pagescategories.category
                            AND categories.fixed = pagescategories.id

            WHERE page = :page OR pagescategories.id = `fixed` ORDER BY `order`');

        $stm->bindParam(':page', $page, PDO::PARAM_INT);
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }
}
