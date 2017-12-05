<?php
namespace Admin\DAO\Session;

class UserSession {
    public function create($e) {
        $_SESSION['authorized'] = serialize($e);
    }

    public function read() {
        if (!isset($_SESSION['authorized'])) {
            return null;
        }

        return unserialize($_SESSION['authorized']);
    }

    public function delete() {
        session_destroy();
        $_SESSION = array();
    }
}
