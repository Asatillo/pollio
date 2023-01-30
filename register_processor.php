<?php
class RegisterUser{

    private $username;
    private $email;
    private $password;
    private $password2;
    public $error;
    public $success;
    private $storage = "users.json";
    private $stored_users;
    private $new_user;

    public function __construct($username, $password, $password2, $email){
        $this->password = filter_var(trim($password));
        $this->password2 = filter_var(trim($password2));
        $this->username = filter_var(trim($username));
        $this->email = filter_var(trim($email));

        $this->stored_users = json_decode(file_get_contents($this->storage), true);

        $this->new_user = [
            "id" => uniqid("user", false),//sprintf("userid%d", count($this->stored_users)+1),
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "isAdmin" => FALSE,
        ];

        if($this->insertUser()){
            session_start();
            $_SESSION['user'] = $this->username;
            header("location: index.php");
            exit();
        }
    }

    private function checkFieldValues(){
        if(empty($this->username) || empty($this->email) || empty($this->password) || $this->password != $this->password2){
            $this->error = "All fields are required*";
            return false;
        }else{
            return true; 
        }
    }

    private function usernameExists(){
        foreach($this->stored_users as $user){
            if($this->username == $user['username']){
                return true;
            }
        }
        return false;
    }

    // HEH, actually a joke :)
    private function passwordExists(){
        foreach($this->stored_users as $user){
            if($this->password == $user['password']){
                $this->error = "Password already taken by {$user['username']}, please choose a different one.";
                return true;
            }
        }
    }

    private function insertUser(){
        if(!$this->check_len($this->username)){
            $this->error = "*The username must be longer than 5 and shorter than 20 characters";
            return false;
        }

        if(!$this->regex_username()){
            $this->error = "*Username must contain only letters (uppercase or lowercase) and numbers";
            return false;
        }

        if(!$this->check_len($this->password)){
            $this->error = "*The password must be longer than 5 and shorter than 20 characters";
            return false;
        }

        if(!$this->regex_pword()){
            $this->error = "The password must include at least one uppercase, lowercase, number and one of the #, @, $, %";
            return false;
        }

        if($this->password != $this->password2){
            $this->error = "*Passwords must match";
            return false;
        }

        if($this->usernameExists()){
            $this->error = "*Username you chose is already in use";
            return false;
        }

        if(!$this->regex_email()){
            $this->error = "*Incorrect email";
            return false; 
        }

        if(!$this->checkFieldValues()){
            $this->error = "*All fields are required";
            return false;
        }

        array_push($this->stored_users, $this->new_user);
        if(file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))){
            $this->success = "Your registration was successfull";
            return true;
        }else{
            return $this->error = "Something went wrong";
        }
    }

    function regex_pword(){
        return preg_match('/[a-z]/', $this->password) &&
            preg_match('/[A-Z]/', $this->password) &&
            preg_match('/[0-9]/', $this->password) &&
            preg_match('/[\#\@\$\%]/', $this->password);
    }

    function check_len($item){
        $length = strlen($item);
        if ($length > 5 && $length < 20) {
            return true;
        }
        return false;
    }

    function regex_username(){
        return preg_match('/^[a-zA-Z0-9]+$/', $this->username);
    }

    function regex_email(){
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $this->email);
    }
}
?>
