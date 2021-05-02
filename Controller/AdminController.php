<?php

namespace App\Controller;

use App\Core\Controller;

class AdminController extends Controller {
    public function login() {
        if($this->getRequestMethod() == "post") {
            $username = $this->request->post("username");
            $password = $this->request->post("password");

            echo "$username :: $password";die;
            echo "<pre>";print_r($_POST);echo "</pre>";die();
        }
        // $this->setLayout("asd");
        return $this->render("login", ["name"=>"CP Test"]);
    }
    function register() {
        if($this->getRequestMethod() == "post") {
            echo "<pre>";print_r($_POST);echo "</pre>";die();
        }
        return $this->render("registration", ["name"=>"CP Test"]);
    }
}