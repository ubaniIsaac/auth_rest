<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once 'Model.php';

class UserModel extends Model {

    // protected $id;
    protected $name;
    protected $email;
    protected $password;

	protected  $table = 'users';
	protected  $table_fields = array('name', 'email', 'password');


    function __construct(){
        parent::__construct();
    }

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
                echo json_encode(array(
                    "message"=> "Logged in succefully",
                    "data"=> $result[0]
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

}