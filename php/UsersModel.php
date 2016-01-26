<?php
require_once('DbManager.php');

class UsersModel extends DbManager
{
    public function Login($user, $password)
    {
        if($this->dbh === null) return;
        
        //ユーザー情報を取得
        $sql = "SELECT * FROM users WHERE email=:user";

        try
        {
            $stmt = $this->dbh->prepare($sql);

            $stmt->bindValue(":user", $user, PDO::PARAM_STR);

            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $userInfo = array();
            
            //パスワードを比較
            if($res['password'] == $password)
            {
                session_regenerate_id(true);
                               
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
        catch(PDOException $e)
        {
            echo "login failed.";
        }
    }
    
}
