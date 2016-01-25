<?php

    require_once('BlogsModel.php');

    $user = $_GET['user'];

    $model = new BlogsModel();
    
    $model->ConnectDb();
    
    $model->GetMaxNumOfBlogs($user);
    
    $model->DisConnectDb();