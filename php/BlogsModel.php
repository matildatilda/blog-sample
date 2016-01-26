<?php
require_once('DbManager.php');

class BlogsModel extends DbManager
{
    public function GetBlogList($start, $limit)
    {
        if ($this->dbh === null) return;

        $start = (int)$start;
        $limit = (int)$limit;
        
        if (!is_int($start))    return;
        if (!is_int($limit))    return;

        $offset = $start * $limit;

        $sql = "SELECT * FROM blogs ORDER BY created DESC LIMIT :offset, :limit;";
        $stmt = $this->dbh->prepare($sql);
        
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
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

        $sql = "SELECT COUNT(*) AS CNT FROM blogs WHERE user=:user;";
        
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":user", $user, PDO::PARAM_STR);
        
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $blogInfo = array(
            'maxNumOfBlogs'=>$res['CNT']
        );
        
        header('Content-type: application/json');
        echo json_encode($blogInfo);        

    }

    public function AddBlog($user, $title, $text_of_blog, $created)
    {
        if ($this->dbh === null) return;

        if (!is_string($user))  return;
        if (!is_string($title)) return;
        if (!is_string($text_of_blog))  return;
        if (!is_string($created))   return;
    
        $sql = "INSERT INTO blogs (user, title, text_of_blog, created) VALUES (:user, :title, :text_of_blog, :created);";
        $stmt = $this->dbh->prepare($sql);
        
        $stmt->bindValue(":user", $user, PDO::PARAM_STR);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":text_of_blog", $text_of_blog, PDO::PARAM_STR);
        $stmt->bindValue(":created", $created, PDO::PARAM_STR);
        
        $stmt->execute();
    }
    
    public function DeleteBlog($user, $id)
    {
        if ($this->dbh === null) return;
    
        $id = (int)$id;
        
        if (!is_string($user))  return;
        if (!is_int($id))   return;
    
        $sql = "DELETE FROM blogs WHERE user=:user AND id=:id;";
        $stmt = $this->dbh->prepare($sql);

        $stmt->bindValue(":user", $user, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
    }
    
    public function UpdateBlog($user, $id, $title, $text_of_blog, $changeDate, $created)
    {
        if ($this->dbh === null) return;
        
        $id = (int)$id;
        $changeDate = (bool)$changeDate;
        
        if (!is_string($user))  return;
        if (!is_int($id))   return;
        if (!is_string($title)) return;
        if (!is_string(text_of_blog))    return;
        if (!is_bool($changeDate))  return;
        if (!is_string($created))   return;
        
        $sql = "UPDATE blogs SET title=:title, text_of_blog=:text_of_blog ";
        if ($changeDate)
        {
            $sql = $sql.", created=:created ";    
            
        }
        $sql = $sql."WHERE user=:user AND id=:id;";
        
        $stmt = $this->dbh->prepare($sql);
        
        $stmt->bindValue(":user", $user, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":text_of_blog", $text_of_blog, PDO::PARAM_STR);
        $stmt->bindValue(":created", $created, PDO::PARAM_STR);
        
        $stmt->execute();
    }
    
}
