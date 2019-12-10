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
            $user_hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(firstname, lastname, email, username, password, phone_number)
                               VALUES(:firstname, :lastname, :email, :username, :password, :phone_number)";
            $query = $this->db->prepare($sql);
            $query->bindParam(":firstname",$firstname);
            $query->bindParam(":lastname",$lastname);
            $query->bindParam(":email",$email);
            $query->bindParam(":username",$username);
            $query->bindParam(":password", $user_hashed_password);
            $query->bindParam(":phone_number",$phone_number);
            $query->execute();
        }catch (PDOException $exception){
            array_push($errors,$exception->getMessage());
        }
    }
    public function updateUsername($username,$id_users){
        try {
            $sql = "UPDATE users SET username =:username WHERE id_users=:id_users";
            $query = $this->db->prepare($sql);
            $query->bindParam(":username", $username);
            $query->bindParam(":id_users", $id_users);
            $query->execute();
        }catch (PDOException $exception){
            array_push($errors,$exception->getMessage());
        }
    }
    public function updatePassword($password,$id_users){
        try {
            $user_hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password =:password WHERE id_users=:id_users";
            $query = $this->db->prepare($sql);
            $query->bindParam(":password", $user_hashed_password);
            $query->bindParam(":id_users", $id_users);
            $query->execute();
        }catch (PDOException $exception){
            array_push($errors,$exception->getMessage());
        }
    }
    public function updateFirstname($firstname,$id_users){
        try {
            $sql = "UPDATE users SET firstname =:firstname WHERE id_users=:id_users";
            $query = $this->db->prepare($sql);
            $query->bindParam(":firstname", $firstname);
            $query->bindParam(":id_users", $id_users);
            $query->execute();
        }catch (PDOException $exception){
            array_push($errors,$exception->getMessage());
        }
    }
    public function updateLastname($lastname,$id_users){
        try {
            $sql = "UPDATE users SET lastname =:lastname WHERE id_users=:id_users";
            $query = $this->db->prepare($sql);
            $query->bindParam(":lastname", $lastname);
            $query->bindParam(":id_users", $id_users);
            $query->execute();
        }catch (PDOException $exception){
            array_push($errors,$exception->getMessage());
        }
    }
    public function updatePhone_number($phone_number,$id_users){
        try {
            $sql = "UPDATE users SET phone_number =:phone_number WHERE id_users=:id_users";
            $query = $this->db->prepare($sql);
            $query->bindParam(":phone_number", $phone_number);
            $query->bindParam(":id_users", $id_users);
            $query->execute();
        }catch (PDOException $exception){
            array_push($errors,$exception->getMessage());
        }
    }
    public function updateEmail($email,$id_users){
        try {
            $sql = "UPDATE users SET email =:email WHERE id_users=:id_users";
            $query = $this->db->prepare($sql);
            $query->bindParam(":email", $email);
            $query->bindParam(":id_users", $id_users);
            $query->execute();
        }catch (PDOException $exception){
            array_push($errors,$exception->getMessage());
        }
    }
    public function login($username, $password)
    {
        try {
            $sql = "SELECT * FROM users WHERE username=:username LIMIT 1";
            $query = $this->db->prepare($sql);
            $query->bindParam(":username", $username);
            $query->execute();
            $returned_row = $query->fetch(PDO::FETCH_ASSOC);
            if ($query->rowCount() > 0) {
                if (password_verify($password, $returned_row['password'])) {
                    $_SESSION['user_session'] = $returned_row['id_users'];
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