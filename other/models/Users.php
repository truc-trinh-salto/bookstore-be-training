<?php

class Users {
    public $id;
    public $username;

    public $fullname;

    public $phonenumber;

    public $birthday;

    public $password;

    public $role;

    public $createdAt;


    public function __construct($id, $username, $fullname, $phonenumber, $birthday, $password, $role, $createdAt) {
        $this->id = $id;
        $this->username = $username;
        $this->fullname = $fullname;
        $this->phonenumber = $phonenumber;
        $this->birthday = $birthday;
        $this->password = $password;
        $this->role = $role;
        $this->createdAt = $createdAt;
    }

    public static function getLogin(){
        
    }
    
}
?>
