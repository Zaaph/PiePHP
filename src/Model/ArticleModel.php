<?php

    namespace Model;

    class ArticleModel extends \Core\Entity
    {

        protected $table = "article";
        private static $relation = array("has many tag", "has many comment");

        public function read_all() {
            $query = "SELECT * FROM " . $this->table . ";";
            $exec = $this->db->prepare($query);
            $exec->execute();
            $res = $exec->fetchAll();
            return $res;
        }

        public function save() {
            $orm = new \Core\ORM();
            $id = $orm->create($this->table,
                ["titre" => $this->titre, "content" => $this->content,
                    "author" => $this->author]);
            return $id;
        }

        public function read($id) {
            $orm = new \Core\ORM();
            $res = $orm->read($this->table, $id);
            return $res;
        }

        public function update($id, $fields) {
            $orm = new \Core\ORM();
            $res = $orm->update($this->table, $id, $fields) ? true : false;
            return $res;
        }

        public function delete($id) {
            $orm = new \Core\ORM();
            $res = $orm->delete($this->table, $id) ? true : false;
            return $res;
        }

        public function getRelation() {
            return self::$relation;
        }
    }

?>