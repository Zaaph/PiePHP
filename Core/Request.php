<?php

    namespace Core;

    class Request
    {
        public function getQueryParams() {
            foreach ($_POST as $key => $value) {
                if ($key !== "submit") {
                    $_POST[$key] = trim(stripslashes(htmlspecialchars(
                        $_POST[$key])));
                } else {
                    unset($_POST[$key]);
                }
            }
            foreach ($_GET as $key => $value) {
                if ($key !== "submit") {
                    $_GET[$key] = trim(stripslashes(htmlspecialchars(
                        $_GET[$key])));
                } else {
                    unset($_GET[$key]);
                }
            }
            if (!empty($_POST)) {
                return $_POST;
            } elseif (!empty($_GET)) {
                return $_GET;
            }
            return false;
        }
    }

?>