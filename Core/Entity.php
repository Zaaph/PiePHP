<?php

    namespace Core;

    class Entity
    {
        protected $table = "";

        public function __construct($params) {
            /*if (empty($params) && $_SERVER["REQUEST_URI"] !== "/PiePHP/") {
                header("Location: /PiePHP/");
            }*/
            foreach($params as $key => $value) {
                if ($key === "id") {
                    $orm = new \Core\ORM();
                    $tab = $orm->read($this->table, $value);
                }
            }
            if (!isset($tab)) {
                $tab = $params;
            }
            if ($tab) {
                foreach ($tab as $key => $value) {
                    if (is_string($key)) {
                        $this->{$key} = $value;
                    }
                }
            }
        }
    }

?>