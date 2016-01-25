<?php

    require_once('BlogsModel.php');

    $user = $_POST['user'];
    $id = $_POST['id'];
    $title = $_POST['title'];
    $text_of_blog = $_POST['text_of_blog'];
    $created = $_POST['created'];
    $changeDate = $_POST['changeDate'];

    $model = new BlogsModel();
    
    $model->ConnectDb();
    
    $model->UpdateBlog($user, $id, $title, $text_of_blog, $changeDate, $created);
    
    $model->DisConnectDb();