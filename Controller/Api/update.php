<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '/xampp/htdocs/auth_rest/Models/UserModel.php';

$user = new UserModel;

$id = isset($_GET['id']) ? $_GET['id'] : die();

$request = json_decode(file_get_contents("php://input"));

$result = $user->update($id, $request);
