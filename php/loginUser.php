<?php
    require_once('UsersModel.php');
    
    $user = $_POST['user'];
    $password = $_POST['password'];
    
    $model = new UsersModel();
    
    $model->ConnectDb();
    
    $model->Login($user, $password);
    
    $model->DisConnectDb();
    
