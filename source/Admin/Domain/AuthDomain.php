<?php
namespace Admin\Domain;

use Admin\DAO\DB\AdminsDB;
use Admin\DAO\Session\UserSession;

class AuthDomain {
    public function logon($email, $password) {
        $dao = new AdminsDB;
        $admin = $dao->readByEmailAndPassword($email, $password);

        if ($admin === false) {
            throw new LogonException('Usuário ou senha incorretos');
        }

        $dao = new UserSession;
        $dao->create($admin);
    }

    public function logout() {
        $dao = new UserSession;
        $dao->delete();
    }
}
