<?php

    require_once('BlogsModel.php');

    $start = $_GET['start'];
    $limit = $_GET['limit'];

    $model = new BlogsModel();
    
    $model->ConnectDb();
    
    $model->GetBlogList($start, $limit);
    
    $model->DisConnectDb();