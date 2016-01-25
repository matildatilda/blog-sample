<?php
require_once('DbManager.php');

class UsersModel extends DbManager
{
    public function Login($user, $password)
    {
        if($this->dbh === null) return;
        
        $sql = "SELECT COUNT(*) AS CNT FROM users WHERE email='".$user."' AND password='".$password."';";
        
        $rows = $this->dbh->query($sql);
        $res = $rows->fetch(PDO::FETCH_ASSOC);
        
        $userInfo = array();

        if($res['CNT'] == 1)
        {
            $userInfo = array(
                'user'=>$user
            );        
        }
        else
        {
            $userInfo = array(
                'user'=>''
            );        
        }
        
        header('Content-type: application/json');
        echo json_encode($userInfo);        

    }
    
}
