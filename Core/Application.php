<?php

namespace App\Core;

class Application {
    public $view_path;
    public $site_url;
    public $assets_path; 

    public static Database $database;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Session $session;
    public static $GLOBLE_VARIABLES;
    function __construct(Path $path, $config=[])
    {
        $this->view_path = $path->VIEW_DIR_PATH.DIRECTORY_SEPARATOR;
        $this->assets_path = $path->ASSETS_DIR_PATH.DIRECTORY_SEPARATOR;
        $this->site_url = $config["site_url"];

        self::$app = $this;

        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->session = new Session();

        if(!empty($config["GLOBAL_VARIABLE"]) && empty(self::$GLOBLE_VARIABLES)) self::$GLOBLE_VARIABLES = $config["GLOBAL_VARIABLE"];
        if(!empty($config["db"]) && empty(self::$database)) self::$database = new Database($config["db"]);
    }

    public function setGlobalVariable($key, $val) {

    }
    public function run(){
        echo $this->router->resolved();
    }
}