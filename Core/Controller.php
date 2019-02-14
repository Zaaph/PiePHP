<?php

    namespace Core;

    class Controller 
    {
        public static $_render;

        public function __construct() {
            $this->request = new \Core\Request();
            $this->request->getQueryParams();
        }

        public function indexAction() {
            if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
                header("Location: /PiePHP/user");
            } else {
                $this->render("welcome");
            }
        }

        protected function render($view, $scope = []) {
            extract($scope);
            $file = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), "src",
                "View", str_replace('Controller', '',
                    basename(get_class($this))), $view]) . ".php";
            $file = str_replace("/Core\\", "", $file);
            if (file_exists($file)) {
                file_put_contents($file, \Core\TemplateEngine::parser(
                    file_get_contents($file)));
                ob_start();
                include($file);
                $view = ob_get_clean();
                ob_start();
                include(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), "src",
                    "View", "index"]) . ".php");
                self::$_render = ob_get_clean();
            }
        }

        public function errorRender($params = NULL) {
            $this->render("Error/404");
        }

        public function infoPageAction() {
            $this->render("User/infoPage");
        }

        public function modifyAction() {
            $this->render("User/modify");
        }
    }

?>