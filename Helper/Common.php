<?php

if(!function_exists("setGlobalVariable")) {
    function setGlobalVariable($index, $value) {
        global ${$index};
        ${$index} = $value;
    }
}

if(!function_exists("getGlobalVariable")) {
    function gettGlobalVariable($index) {
        global ${$index};
        return ${$index};
    }
}