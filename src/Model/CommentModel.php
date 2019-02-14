<?php

    namespace Model;

    class CommentModel extends \Core\Entity
    {
        protected $table = "comment";
        private static $relation = array("has one article");

        public function getRelation() {
            return self::$relation;
        }
    }

?>