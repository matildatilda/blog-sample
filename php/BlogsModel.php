<?php
require_once('DbManager.php');

class BlogsModel extends DbManager
{
    public function GetBlogList($start, $limit)
    {
        if ($this->dbh === null) return;

        $offset = $start * $limit;

        $sql = "SELECT * FROM blogs ORDER BY created DESC LIMIT ".$offset.", ".$limit.";";  
        $rows = $this->dbh->query($sql);

        $blogs = array();

        foreach($rows as $row)
        {
            $blogs[] = array(
                'id'=>$row['id'],
                'title'=>$row['title'],
                'text_of_blog'=>$row['text_of_blog'],
                'created'=>$row['created']
            );
        }
        
        header('Content-type: application/json');
        echo json_encode($blogs);        
    }

    public function GetMaxNumOfBlogs($user)
    {
        if ($this->dbh === null) return;

        $sql = "SELECT COUNT(*) AS CNT FROM blogs WHERE user='".$user."';";
        
        $rows = $this->dbh->query($sql);
        $res = $rows->fetch(PDO::FETCH_ASSOC);
        
        $blogInfo = array();
        
        $blogInfo = array(
            'maxNumOfBlogs'=>$res['CNT']
        );
        
        header('Content-type: application/json');
        echo json_encode($blogInfo);        

    }

    public function AddBlog($user, $title, $text_of_blog, $created)
    {
        if ($this->dbh === null) return;
    
        $sql = "INSERT INTO blogs (user, title, text_of_blog, created) VALUES ('".$user."', '".$title."', '".$text_of_blog."', '".$created."');";

        $this->dbh->exec($sql);        
    }
    
    public function DeleteBlog($user, $id)
    {
        if ($this->dbh === null) return;
    
        $sql = "DELETE FROM blogs WHERE user='".$user."' AND id=".$id.";";

        $this->dbh->exec($sql);        
    }
    
    public function UpdateBlog($user, $id, $title, $text_of_blog, $changeDate, $created)
    {
        if ($this->dbh === null) return;
        
        $sql = "UPDATE blogs SET title='".$title."', text_of_blog='".$text_of_blog."'";
        if ($changeDate)
        {
            $sql = $sql." , created='".$created."' ";    
            
        }
        $sql = $sql." WHERE user='".$user."' AND id=".$id.";";
        
        $this->dbh->exec($sql);        
    }
    
}
