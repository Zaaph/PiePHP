<?php
    namespace Core;
    use PDO;

    class Database 
    {
        public static function getDB() {
            try {
                $database = new PDO("mysql:host=localhost;dbname=wac_exam;
                    charset=UTF8","root", "root1234");
                $database->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                echo "La connexion à la base a échoué : " .
                    $error->getMessage();
            }
            return $database;
        }
    }

?>