<?php

namespace app {

    use bootphp\rudrax\AppLoader;

    include_once "lib/autoload.php";

    class Index extends AppLoader
    {
        public static $DISPLAY_ERROR = TRUE;
        public static $RX_MODE_DEBUG = TRUE;

        public function __construct()
        {
            static::$DISPLAY_ERROR = isset($_GET["_display_errors_"]) && !empty($_GET["_display_errors_"]);
        }
    }

    (new Index())->execute(__DIR__);
}
