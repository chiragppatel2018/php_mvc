<?php

namespace App\Core;

class Path {
    public $SYS_DIR_PATH = __DIR__;

    public $ROOT_DIR_PATH = __DIR__.'/..';

    public $CONTROLLER_DIR_PATH = __DIR__.'/../Controller';

    public $VIEW_DIR_PATH = __DIR__.'/../View';

    public $HELPER_DIR_PATH = __DIR__.'/../Helper';

    public $ASSETS_DIR_PATH = __DIR__.'/../Assets';
}