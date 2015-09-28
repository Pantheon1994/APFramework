<?php

class userController
    extends baseController {

    public function createUser()
    {
        try {
            $user = R::find('user', 'email = ?', [$this->request()->email]);
            if($user){
               $this->response($user);
            } else {
                $user = R::dispense( 'user' );
                $user->email = $this->request()->email;
                $user->password = sha1($this->request()->password);
                $user->authToken = 0;
                 R::store($user);
                $this->response($user);
            }
        } catch(Exception $e) {
            echo $e->getMessage() . $e->getFile() . $e->getLine();
        }
    }

    public function connectionUser()
    {
        try {
            $user = R::findOne('user', 'email = ? AND password = ?',
                array($this->request()->email, sha1($this->request()->password)));
            if($user) {
                $auth = new auth($user->id);
                $auth->set();
                $auth->update($user->id);
                $this->response($user);
            } else {
                $this->response($user);
            }
        } catch(Exception $e) {
            echo $e->getMessage() . $e->getFile() . $e->getLine();
        }

    }
}