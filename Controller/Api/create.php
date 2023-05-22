<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '/xampp/htdocs/auth_rest/Models/UserModel.php';

$user = new UserModel;

$request = json_decode(file_get_contents("php://input"));

$result = $user->create($request);
