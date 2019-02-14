<?php

    namespace Model;

    class TagModel extends \Core\Entity
    {
        protected $table = "tag";
        private static $relation = array("has many article");

        public function getRelation() {
            return self::$relation;
        }
    }

?>