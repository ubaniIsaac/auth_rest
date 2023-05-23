<?php

require_once '../auth_rest/Models/TodoModel.php';
require_once '../auth_rest/Middlewares/AuthMiddleware.php';

class TodoController extends TodoModel {

    function __construct(){
        parent::__construct();
        $allHeaders = getallheaders();
        $auth = new AuthMiddleware($this->conn, $allHeaders);
        $result =  $auth->isValid();
        if($result['success'] !== 1){
             http_response_code(401);  
             new Exception("Unauthorised user. Please login", 1);
            echo json_encode(
                array(
                    "message"=>"Unauthorised user. Please login"
                )
            );
            exit();
        }
    }
  
}

