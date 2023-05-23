<?php

require_once '../auth_rest/Models/UserModel.php';
require_once '../auth_rest/Middlewares/JwtHandler.php';
require_once '../auth_rest/Middlewares/AuthMiddleware.php';


class UserController extends UserModel {

    function checkEmail($email){
        $query =  "SELECT * FROM $this->table WHERE email = '$email' LIMIT 1";
             $stmt = $this->conn->prepare($query);

             $stmt->execute();
     
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             return $result;
    }

    public function register($request){
	 		$result = $this->checkEmail($request->email);
            $request->password = md5($request->password);
             if ($result) {
                echo json_encode(array(
                    "message"=> "User with this email already exits"
                ));
                return;
             }
             $result = $this->create($request);
             return $result;

    }
    public function login($request){
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if ($requestMethod == 'POST'){
        $result = $this->checkEmail($request->email);

             if (!$result) {
                echo json_encode(array(
                    "message"=> "No User with this email"
                ));
                return;
             }
             $request->password = md5($request->password);
             if($request->password == $result[0]['password']){

                $jwt = new JwtHandler();
                    $token = $jwt->jwtEncodeData(
                        'http://localhost/auth_rest/',
                        array("user_id"=> $result[0]['id'])
                    );
                echo json_encode(array(
                    "message"=> "Logged in succefully",
                    "data"=> array(
                        "id"=> $result[0]['id'],
                        "name"=> $result[0]['name'],
                        "email"=> $result[0]['email'],
                    ),
                    "token"=> $token
                ));
                return;
            }
            http_response_code(401);
            echo json_encode( array(
                "message" => "Invalid credentials"
            ));
        }else {
            echo json_encode(array(
              "message"=> "invalid method"
            ));
          http_response_code(422);
          }
    } 

    public function updateUser($request){
        $allHeaders = getallheaders();
        $auth = new AuthMiddleware($this->conn, $allHeaders);

        $result =  $auth->isValid();
        if($result['success'] == 1){
           $user_id = $result['user']['id'];
           $this->update($user_id, $request);
        }

    }

}


