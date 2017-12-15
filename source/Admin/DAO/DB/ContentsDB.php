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

namespace Admin\DAO\DB;

use Squille\Core\Collection;
use \PDO;

class ContentsDB extends DAODB
{
    public function read()
    {
        $stm = $this->connection->prepare('SELECT * FROM contents');
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function readById($id)
    {
        $stm = $this->connection->prepare('SELECT * FROM contents WHERE id = :id');

        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchObject();
    }

    public function create($e)
    {
        $stm = $this->connection->prepare('
                INSERT contents SET
                    id = :id,
                    description = :description,
                    `date` = :date,
                    text = :text,
                    fixed = :fixed');

        $e->id = $this->getNextIndex();
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stm->bindParam(':description', $e->description, PDO::PARAM_STR);
        $stm->bindParam(':date', $e->date, PDO::PARAM_STR);
        $stm->bindParam(':text', $e->text, PDO::PARAM_STR);
        $stm->bindParam(':fixed', $e->fixed, PDO::PARAM_INT);

        $stm->execute();

        if ($e->category) {
            $stmC = $this->connection->prepare('
                    UPDATE contents SET
                        category = :category
                    WHERE
                        id = :id');

            $stmC->bindParam(':category', $e->category, PDO::PARAM_INT);
            $stmC->bindParam(':id', $e->id, PDO::PARAM_INT);

            $stmC->execute();
        }
    }

    public function update($e)
    {
        $stm = $this->connection->prepare('
                UPDATE contents SET
                    description = :description,
                    date = :date,
                    text = :text,
                    fixed = :fixed
                WHERE
                    id = :id
                ');

        $stm->bindParam(':description', $e->description, PDO::PARAM_STR);
        $stm->bindParam(':date', $e->date, PDO::PARAM_STR);
        $stm->bindParam(':text', $e->text, PDO::PARAM_STR);
        $stm->bindParam(':fixed', $e->fixed, PDO::PARAM_INT);
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);

        $stm->execute();

        if ($e->category) {
            $stmC = $this->connection->prepare('
                    UPDATE contents SET
                        category = :category
                    WHERE
                        id = :id');

            $stmC->bindParam(':category', $e->category, PDO::PARAM_INT);
        } else {
            $stmC = $this->connection->prepare('
                    UPDATE contents SET
                        category = NULL
                    WHERE
                        id = :id');

        }

        $stmC->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stmC->execute();
    }

    public function deleteById($id)
    {
        $stm = $this->connection->prepare('DELETE FROM contents WHERE id = :id');
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getNextIndex()
    {
        $stm = $this->connection->prepare('SELECT MAX(id) max_id FROM contents');
        $stm->execute();
        $e = $stm->fetchObject();
        return $e->max_id + 1;
    }
}
