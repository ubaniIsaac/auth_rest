<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include '/xampp/htdocs/auth_rest/Models/UserModel.php';

$user = new UserModel;

$id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $user->find($id);

