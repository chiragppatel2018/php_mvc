<?php

namespace App\Core;

class Request {
    public function getPath() {
        $path = $_SERVER["REQUEST_URI"] ?? '/';
        $path = trim($path,"/");
        // $path = str_replace(Application::$app->site_url, "", $path);
        $param_val = [];
        if(substr_count($path, "/") > 1) {
            $uri = explode("/", $path);
            
            $path=$uri[0]."/".$uri[1];
            unset($uri[0]);
            unset($uri[1]);
            $param_val = array_values($uri);
        }
        $path .= "/";

        $pos = strpos($path, "?");

        if($pos == false) return ["path"=>$path, "param_val"=>$param_val];

        return ["path"=>substr($path, 0, $pos), "param_val"=>[]];
    }

    public function getMethod() {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function postAll() {
        $data = [];
        if ($this->getMethod() === "post") {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }

    public function get($index, $value=null) {
        if(!empty($_GET[$index])) {
            $value = filter_input_array(INPUT_GET, $index, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $_GET[$index] = $value;
        $this->request($index, $value);
        return $value;
    }

    public function post($index, $value=null) {
        if(!empty($_POST[$index])) {
            $value = filter_input(INPUT_POST, $index, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $_POST[$index] = $value;
        $this->request($index, $value);
        return $value;
    }

    public function file($index) {
        if(!empty($_FILES[$index])) {
            return $_FILES[$index];
        }
    }

    public function request($index, $value=null) {
        $_REQUEST[$index] = $value;
    }

    public function is_ajax() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' );
    }

    function redirect($url) {
        $url = Application::$app->site_url.$url;
        header("location:$url");exit;
    }   
}