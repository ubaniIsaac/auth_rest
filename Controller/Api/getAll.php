<?php
include '/xampp/htdocs/auth_rest/Models/UserModel.php';

$users = new UserModel;

$result = $users->getAll();

