<?php

class baseController {

    private $arrayResponse;

    public static function call() {

        $args = func_get_args();

        try {
            if(!is_null($args)) {
                $controllerParams = explode('@', $args[0]);
                if(!isset($controllerParams[0]) || !isset($controllerParams[1])) {
                    throw new Exception('Missing params to controller settings');
                } else {

                    if(isset($args[1])) {
                        $controller = array(
                            "class" => $controllerParams[0],
                            "method" => $controllerParams[1],
                            "params" => $args[1]
                        );
                    } else {
                        $controller = array(
                            "class" => $controllerParams[0],
                            "method" => $controllerParams[1],
                            "params" => null
                        );
                    }
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


    public function objectToArray( $object )
    {
        if( !is_object( $object ) && !is_array( $object ) )
        {
            return $object;
        }
        if( is_object( $object ) )
        {
            $object = get_object_vars( $object );
        }
        return array_map( 'objectToArray', $object );
    }




    protected function response($data) {

        if(is_object($data)) {
            $this->arrayResponse = (array)($data);
        }

        $arrayError = array(
            "RESPONSE" => "EMPTY"
        );

        $arrayOk = array(
            "RESPONSE" => "OK"
        );

        if(empty($this->arrayResponse)) {
           echo json_encode($arrayError);
        } else {
            echo  json_encode(array_merge($this->arrayResponse, $arrayOk));
        }
    }

    /**
     * @param $include
     */

    private static function includeController ($include) {
        include 'controller/'. $include . ".php";
    }

}