<?php
include '../auth_rest/Models/UserModel.php';

$users = new UserModel;

$result = $users->find(8);

print_r($result);
