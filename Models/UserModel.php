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

}