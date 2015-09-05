<?php

class auth {

    private $key;

    public function __construct($id) {
        if(is_int($id) || !empty($id)) {
            $this->key = sha1($id);
        } else {
            throw new Exception("Auth key must be a number");
        }
    }

    public function set() {
        if(isset($this->key)) {
            setcookie("authToken", $this->key, time() + (86400 * 30), "/"); // 86400 = 1 day
        } else {
            throw new Exception("Key is not initialized");
        }
    }

    public function delete() {
        setcookie("authToken", "", time() - 3600 * 86400);
    }

    public function update($id) {

        $newAuth = R::load('user', $id);
        $newAuth->authToken = $this->key;
        $this->set();
        R::store($newAuth);
    }

    public static function getTokenAuthId() { // get current userId
        return R::find('user', 'authToken = ?', $_COOKIE['authToken']);
    }

}