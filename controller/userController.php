<?php


class userController extends baseController {

    public function createUser() {
        try {
            if(R::find('user', 'email = ?', [$this->request()->email])){
               echo "no";
            } else {
                $user = R::dispense( 'user' );
                $user->email = $this->request()->email;
                $user->password = sha1($this->request()->password);
                $user->authToken = 0;
                $userId = R::store($user);
                // Auth.
                $this->callBack($userId);
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    /**
     * @throws Exception
     */
    public function connectionUser() {


        try {
            $userId = R::findOne('user', 'email = ? AND password = ?',
                array($this->request()->email, sha1($this->request()->password)));
            if($userId) {
                $auth = new auth($userId->id);
                $auth->set();
                $auth->update($userId->id);
                // Send CallBack
                $this->callBack($userId);
            } else {
                //Send Callback
                $this->callBack($userId);
            }
        } catch(Exception $e) {
            echo $e->getMessage() . $e->getFile();
        }

    }

}