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

class AdministratorsDB extends DAODB
{
    public function read()
    {
        $stm = $this->connection->prepare('SELECT * FROM admins');
        $stm->execute();

        $c = new Collection;
        while ($e = $stm->fetchObject()) {
            $c->append($e);
        }

        return $c;
    }

    public function readById($id)
    {
        $stm = $this->connection->prepare('SELECT * FROM admins WHERE id = :id');

        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchObject();
    }

    public function create($e)
    {
        $stm = $this->connection->prepare('
                INSERT admins SET
                    id = :id,
                    name = :name,
                    email = :email,
                    password = :password,
                    avatar = :avatar');

        $e->id = $this->getNextIndex();
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);
        $stm->bindParam(':name', $e->name, PDO::PARAM_STR);
        $stm->bindParam(':email', $e->email, PDO::PARAM_STR);
        $stm->bindParam(':password', $e->password, PDO::PARAM_STR);
        $stm->bindParam(':avatar', base64_decode($e->avatar), PDO::PARAM_STR);

        $stm->execute();
    }

    public function update($e)
    {
        $stm = $this->connection->prepare('
                UPDATE admins SET
                    name = :name,
                    email = :email,
                    password = :password,
                    avatar = :avatar
                WHERE
                    id = :id
                ');

        $stm->bindParam(':name', $e->name, PDO::PARAM_STR);
        $stm->bindParam(':email', $e->email, PDO::PARAM_STR);
        $stm->bindParam(':password', $e->password, PDO::PARAM_STR);
        $stm->bindParam(':avatar', base64_decode($e->avatar), PDO::PARAM_STR);
        $stm->bindParam(':id', $e->id, PDO::PARAM_INT);

        $stm->execute();
    }

    public function deleteById($id)
    {
        $stm = $this->connection->prepare('DELETE FROM admins WHERE id = :id');
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getNextIndex()
    {
        $stm = $this->connection->prepare('SELECT MAX(id) max_id FROM admins');
        $stm->execute();
        $e = $stm->fetchObject();
        return $e->max_id + 1;
    }
}
