<?php

class UsersController extends BaseController
{
    public function index()
    {
        $this->authorize();
        $this->users = $this->model->getAll();
    }

    public function register()
    {
		// TODO: your user registration functionality will come here ...
        if($this->isPost){
            $username = $_POST['username'];
            if(strlen($username) < 2 || strlen($username) > 50){
                $this->setValidationError("username", "Invalid username!");
            }
            $password=$_POST['password'];
            if(strlen($password) <2 || strlen($password) > 50){
                $this->setValidationError("password", "Invalid password!");
            }
            $full_name=$_POST['full_name'];
            if(strlen($full_name) > 200){
                $this->setValidationError("full_name", "Invalid Full name!");
            }

            if($this->formValid()){
                $userId = $this->model->register($username, $password, $full_name);
                if($userId){
                    $_SESSION['username']=$username;
                    $_SESSION['user_id']=$userId;
                    $this->addInfoMessage("Registration successful.");
                    $this->redirect("posts");
                }else{
                    $this->addErrorMessage("Error: user registration failed!");
                }
            }
        }

    }

    public function login()
    {
		// TODO: your user login functionality will come here ...
        if($this->isPost){
            $username= $_POST['username'];
            $password= $_POST['password'];
            $loggedUserId = $this->model->login($username, $password);
            if($loggedUserId){
                $_SESSION['username']= $username;
                $_SESSION['user_id'] = $loggedUserId;
                $this->addInfoMessage("Login successful.");
                return $this->redirect("posts");
            }
            else{
                $this->addErrorMessage("Error: login failed!");
            }
        }
    }

    public function logout()
    {
		// TODO: your user logout functionality will come here ...
        session_destroy();
        $this->addInfoMessage("Logout successful.");
        $this->redirect("");
    }
}
