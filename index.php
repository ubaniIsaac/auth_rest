<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '/xampp/htdocs/auth_rest/Controller/Api/UserController.php';
include_once '/xampp/htdocs/auth_rest/Controller/Api/TodoController.php';

// localhost/auth_rest/index.php/api/{method}
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
if ((isset($uri[3]) && $uri[3] != 'api') || !isset($uri[5])) {
    http_response_code(404);
    echo 'Not Found';
    exit();
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

$request = json_decode(file_get_contents("php://input"));
$objFeedController;

$objFeedController = ($uri[4]=='user') ? new UserController : new TodoController ;
$strMethodName = $uri[5];

// $objFeedController->{$strMethodName}($request);


if ($id) {    
    $objFeedController->{$strMethodName}($id, $request);
}else{
    $objFeedController->{$strMethodName}($request);
}

