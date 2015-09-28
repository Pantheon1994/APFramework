<?php

class auth {

    private $key;

    public function __construct($id) {
        if(is_int($id) || !empty($id)) {
            $this->key = sha1($id);
        } else {
            throw new Exception("Auth key must be a number and not Empty");
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

    public static function getAuthToken() {
        return $_COOKIE['authToken'];
    }

    public static function getUserId() {
        $user =  R::findOne('user', 'auth_token = ?', array(self::getAuthToken()));
        return $user->id;
    }

    public static function getUserByTokenAuthId() { // get current userId
        try {
            $user =  R::findAndExport('user', 'auth_token = ?', array(self::getAuthToken()));
            return $user;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}