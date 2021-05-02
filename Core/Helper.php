<?php

namespace App\Core;

class Helper {

    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public static function setGlobalVariable($index, $value){
        Application::$GLOBLE_VARIABLES[$index] = $value;
    }

    public static function getSiteUrl() {
        return Application::$app->site_url;
    }
    public function getDataGridData() {
        extract($_REQUEST);

        $order_by = $columns[$order[0]["column"]]["name"]." ".$order[0]["dir"];
        return [
            "order_by"=> $order_by,
            "keyword"=> $search["value"],
            "start" => !empty($start) ? $start : 0,
            "length" => !empty($length) ? $length : 10,
            "draw" => $draw
        ];
    } 
}