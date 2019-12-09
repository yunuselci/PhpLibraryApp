<?php

class user
{
    private $db;

    public function __construct($db_connect)
    {
        $this->db = $db_connect;
    }
    public function register($firstname,$lastname,$email,$username,$password,$phone_number){
        try{
            $sql = "INSERT INTO users(firstname, lastname, email, username, password, phone_number)
                               VALUES(:firstname, :lastname, :email, :username, :password, :phone_number)";
            $query = $this->db->prepare($sql);
            $query->bindParam(":firstname",$firstname);
            $query->bindParam(":lastname",$lastname);
            $query->bindParam(":email",$email);
            $query->bindParam(":username",$username);
            $query->bindParam(":password",$password);
            $query->bindParam(":phone_number",$phone_number);
            $query->execute();
        }catch (PDOException $e){
            array_push($errors,$e->getMessage());
        }
    }
    public function login($email, $username, $password)
    {
        try {
            $sql = "SELECT * FROM users WHERE username=:username OR email=:email LIMIT 1";
            $query = $this->db->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":email", $email);
            $query->execute();
            $returned_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($query->rowCount() > 0) {
                if (password_verify($password, $returned_row['password'])) {
                    $_SESSION['user_session'] = $returned_row['id'];
                    return true;
                } else {
                    return false;
                }
            }
        } catch (PDOException $exception) {
            array_push($errors, $exception->getMessage());
        }
    }
    public function is_logged_in() {
        if (isset($_SESSION['user_session'])) {
            return true;
        }
    }
    public function redirect($url) {
        header("Location: $url");
    }
    public function log_out() {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }
}