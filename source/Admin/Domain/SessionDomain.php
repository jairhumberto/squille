<?php
namespace Admin\Domain;

use Admin\DAO\Session\UserSession;

class SessionDomain {
    public function autenticate() {
        $dao = new UserSession;

        if (!$dao->read()) {
            throw new SessionException;
        }
    }

    public static function readUser() {
        $dao = new UserSession;
        return $dao->read();
    }
}
