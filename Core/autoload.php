<?php


spl_autoload_register(function ($class) {
    $str = dirname(__DIR__) . "/" . str_replace("\\", '/', $class);
    $str2 = dirname(__DIR__) . "/src/" . str_replace("\\", '/', $class);
    if (is_file($str . ".php")) {
        include($str . ".php");
    } else {
        include($str2 . ".php");
    }
});