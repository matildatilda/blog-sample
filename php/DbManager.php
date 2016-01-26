<?php
class DbManager
{
    protected $dbh = null;
    
    public function ConnectDb()
    {
        $dsn = "mysql:dbname=blogsample;host=127.0.0.1";
        $user = getenv('C9_USER');
        $password = "";
        
        try
        {
            $this->dbh = new PDO($dsn, $user, $password);
            $this->dbh->query("SET NAMES utf8");

        }
        catch (PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }                
    }
    
    public function DisConnectDb()
    {
        $this->dbh = null;   
    }
}
