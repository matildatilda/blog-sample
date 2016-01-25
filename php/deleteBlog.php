<?php

    require_once('BlogsModel.php');

    $user = $_POST['user'];
    $id = $_POST['id'];

    $model = new BlogsModel();
    
    $model->ConnectDb();
    
    $model->DeleteBlog($user, $id);
    
    $model->DisConnectDb();