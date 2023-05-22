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

    public function login($request){
	 		$query =  'SELECT * FROM ' .$this->table. ' WHERE email = '. "$request->email" . ' AND password = ' . $request->password.' LIMIT 1';
            echo $query;
             $stmt = $this->conn->prepare($query);

             $stmt->execute();
     
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
             echo json_encode($result);
    } 

}