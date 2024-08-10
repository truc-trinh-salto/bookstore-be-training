<?php
require_once('controllers/base_controller.php');
require_once('models/Users.php');


class UsersController extends BaseController{
    function __construct(){
        $this->folder = 'users';
    }

    public function login(){
        $user = Users::getLogin();
        $data = $user;
        $this->render('login', $data);
    }
}
?>