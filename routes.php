<?php
    
    /*\Core\Router::connect("/log", ["controller" => "",
        "action" => "loginRender"]);
    \Core\Router::connect("/reg", ["controller" => "",
        "action" => "registerRender"]);
    \Core\Router::connect("/app", ["controller" => "app", "action" => "test"]);
    \Core\Router::connect("/register", ["controller" => "user",
        "action" => "register"]);
    \Core\Router::connect("/login", ["controller" => "user",
        "action" => "login"]);*/

    \Core\Router::connect("/register", ["controller" => "user",
        "action" => "register"]);
    \Core\Router::connect("/login", ["controller" => "user",
        "action" => "login"]);
    \Core\Router::connect("/user", ["controller" => "",
        "action" => "infoPage"]);
    \Core\Router::connect("/user/modify", ["controller" => "",
        "action" => "modify"]);
    \Core\Router::connect("/user/modifier", ["controller" => "user", 
        "action" => "modifier"]);
    \Core\Router::connect("/user/deconnect", ["controller" => "user",
        "action" => "deconnect"]);
    \Core\Router::connect("/user/delete", ["controller" => "user", 
        "action" => "delete"]);

?>