<?php

    require_once('BlogsModel.php');

    $user = $_POST['user'];
    $title = $_POST['title'];
    $text_of_blog = $_POST['text_of_blog'];
    $created = $_POST['created'];

    $model = new BlogsModel();
    
    $model->ConnectDb();
    
    $model->AddBlog($user, $title, $text_of_blog, $created);
    
    $model->DisConnectDb();