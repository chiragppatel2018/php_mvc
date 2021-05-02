<?php
namespace App\Core;

use Illuminate\Support\Facades\Route;

class Router {

    protected array $routes = [];
    public $request;
    protected $method_name;
    protected $url_param = [];
    protected $class_obj;
    private Array $params=[];
    public $layout = 'main';

    public function __construct( \App\Core\Request $request)
    {
        $this->request = $request;
    }

    public function setUri($path) {
        $path = trim($path, "/");
        $param = [];

        if(substr_count($path, "/") > 1) {
            $uri = explode("/", $path);
            $path=$uri[0]."/".$uri[1];
            unset($uri[0]);
            unset($uri[1]);
            $param = array_values($uri);
        }
        $path .="/";

        return [
            "path" => $path,
            "param" => $param
        ];
    }
    public function get($path, $callback) {
        $uri = $this->setUri($path);
        $this->routes["get"][$uri["path"]] = [
            "uri" => $callback,
            "param" => $uri["param"]
        ];
    }

    public function post($path, $callback) {
        $uri = $this->setUri($path);
        $this->routes["post"][$uri["path"]] = [
            "uri" => $callback,
            "param" => $uri["param"]
        ];
    }

    protected function loadController($controller) {
        $class_name = $controller[0];
        $this->method_name = $controller[1];
        // Route::$param = $controller[2];
        $class = '\App\Controller\\'.$class_name;
        $this->class_obj = new $class();
    }

    public function resolved() {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        
        $callback = $this->routes[$method][$path["path"]] ?? false;
        if($callback == false) return $this->renderView("404");

        if(is_array($callback["uri"])) {
            $this->loadController($callback["uri"]);
            $param = $path["param_val"];
            $callback["uri"] = [$this->class_obj, $this->method_name];
        }

        if(is_string($callback["uri"])) return $this->renderView($callback["uri"]);
        return call_user_func_array($callback["uri"], $param);
    }

    public function renderView($view, $params=[]) {
        if(is_file(Application::$app->view_path.$view.".php")) {
            $this->params = $params;
            $page_content = $this->renderPageContent($view);
            $page_layout = $this->loadLayout();
            
            return str_replace('{{page_content}}', $page_content, $page_layout);
        }
    }

    public function loadLayout() {
        $this->params = array_merge($this->params, Application::$GLOBLE_VARIABLES);
        extract($this->params);
        if(is_file(Application::$app->view_path."layouts".DIRECTORY_SEPARATOR.$this->layout.".php")) {
            ob_start();
            include_once Application::$app->view_path."layouts".DIRECTORY_SEPARATOR.$this->layout.".php";
            $layout_html = ob_get_contents();
            ob_end_clean();
            
            return $layout_html;
        }
        return "{{page_content}}";
    }

    protected function renderPageContent($page) {
        $this->params = array_merge($this->params, Application::$GLOBLE_VARIABLES);
        extract($this->params);
        ob_start();
        include_once Application::$app->view_path.$page.".php";
        $page_html = ob_get_contents();
        ob_end_clean();
        return $page_html;
    }
}