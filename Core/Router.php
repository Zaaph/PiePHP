<?php

    namespace Core;

    class Router 
    {
        private static $routes;
        public static function connect($url, $route) {
            self::$routes[$url] = $route;
        }

        public static function get($url) {
            $tab = array();
            $ret = array();
            if (isset(self::$routes[$url])) {
                $tab = self::$routes[$url];
                $ret["controller"] = $tab["controller"];
                $ret["action"] = $tab["action"];
                $ret["params"] = array();
            } else {
                $ret["controller"] = "unknown";
                $ret["action"] = "unknown";
                $ret["params"] = array();
            }
            return $ret;
        }
    }

?>