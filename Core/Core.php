<?php
    namespace Core;

    class Core 
    {
        public function run() {
            /*$tab = explode("/", substr($_SERVER["REQUEST_URI"], 1));
            var_dump($tab);
            if (!isset($tab[1]) || $tab[1] === "") {
                $app_c = new \Controller\AppController();
                $app_c->indexAction();
            } elseif ($tab[1] === "user") {
                if (!isset($tab[2]) || $tab[2] === "") {
                    $user_c = new \Controller\UserController();
                    $user_c->indexAction();
                } elseif ($tab[2] === "add") {
                    $user_c = new \Controller\UserController();
                    $user_c->addAction();
                } elseif ($tab[2] !== "404.php" && $tab[2] !== "index.php") {
                    header("Location: 404.php");
                }
            } elseif ($tab[1] !== "404.php" && $tab[1] !== "index.php") {
                header("Location: 404.php");
            }*/
            include "routes.php";
            $matches = array();
            preg_match("/\/[^\/]+(\/.+|\/)/", $_SERVER["REQUEST_URI"], $matches);
            if (isset($matches[1])) {
                if ($matches[1] === "/" &&
                    \Core\Router::get("/")["controller"] === "unknown") {
                    $default_c = new \Core\Controller();
                    $default_c->indexAction();
                    return;
                }
                $route = \Core\Router::get($matches[1]);
                $func_name = $route["action"] . "Action";
                if ($route["controller"] === "") {
                $controller = new \Core\Controller;
                if (method_exists($controller, $func_name)) {
                        $controller->$func_name($route["params"]);
                    } elseif ($route["action"] === "") {
                        $controller->indexAction();
                    } else {
                        $controller->errorRender("Error/404");
                    }
                } else {
                    $this->run_helper($route, $func_name);
                }
            }
        }

        public function run_helper($route, $func_name) {
            if ($route["controller"] !== "unknown") {
                $class = "\\Controller\\" . ucfirst($route["controller"]) .
                    "Controller";
                $controller = new $class();
                if (method_exists($controller, $func_name)) {
                    $controller->$func_name($route["params"]);
                } elseif ($route["action"] === "") {
                    $controller->indexAction();
                } else {
                    $controller = new \Core\Controller();
                    $controller->errorRender();
                    return false;
                }
            } else {
                $controller = new \Core\Controller();
                $controller->errorRender();
            }
        }

        public function __destruct() {
            echo \Core\Controller::$_render;
        }
    }
?>