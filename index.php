<pre><?php
    session_start();
    define('BASE_URI', str_replace('\\', '/', substr(__DIR__,
        strlen($_SERVER['DOCUMENT_ROOT']))));
    if (empty($_SESSION) && $_SERVER["REQUEST_URI"] !== "/PiePHP/") {
        header("Location: /PiePHP/");
    }
    require_once(implode(DIRECTORY_SEPARATOR, ['Core', 'autoload.php']));
    $app = new Core\Core();
    $app->run();

?></pre>