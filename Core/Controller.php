<?php
namespace App\Core;

class Controller {
    protected $request;
    public $helper;
    public $session;
    function __construct()
    {
        $this->request = Application::$app->router->request;
        $this->session = Application::$app->session;
        $this->helper = new Helper($this->request);
    }

    function render($view, $params=[]) {
        return Application::$app->router->renderView($view, $params);
    }

    function getRequestMethod() {
        return $this->request->getMethod();
    }

    function setLayout($layout) {
        Application::$app->router->layout = $layout;
    } 
}