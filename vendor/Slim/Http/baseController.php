<?php

class baseController {

    public static function call() {

        $args = func_get_args();

        try {
            if(!is_null($args)) {
                $controllerParams = explode('@', $args[0]);
                if(!isset($controllerParams[0]) || !isset($controllerParams[1])) {
                    throw new Exception('Missing params to controller settings');
                } else {
                    $controller = array(
                        "class" => $controllerParams[0],
                        "method" => $controllerParams[1],
                        "params" => isset($args[1])
                    );
                    self::includeController($controller['class']);
                    $newObjectController = new $controller['class'];
                    call_user_func(array($newObjectController, $controller['method']), $controller['params']);
                }
            } else {
                throw new Exception('Controller is empty');
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    /**
     * @return mixed
     * Only way to get content with AngularJS
     */
    protected function request() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        return $request;
    }

    /**
     * @param $boolean
     * @param string $success
     * @param string $error
     */

    protected function callBack($boolean) {
        if($boolean) {
            echo "ok";
        } else {
            echo "no";
        }
    }

    /**
     * @param $inc
     */

    private static function includeController ($include) {
        include 'controller/'. $include . ".php";
    }

}