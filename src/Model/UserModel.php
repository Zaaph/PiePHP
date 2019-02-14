<?php

    namespace Model;

    class UserModel extends \Core\Entity
    {
        protected $table = "user";
        public static $relation = array();

        /*public function save($email, $password) {
            $this->db = \Core\Database::getDB();
            $this->email = $email;
            $this->password = password_hash("mon petit salt perso" . $password,
                PASSWORD_BCRYPT);
            $query = "INSERT INTO users (email, password) VALUES (?, ?);";
            $exec = $this->db->prepare($query);
            $exec->execute([$this->email, $this->password]);
        }

        public function create($email, $password) {
            $this->db = \Core\Database::getDB();
            $this->email = $email;
            $this->password = password_hash("mon petit salt perso" . $password,
                PASSWORD_BCRYPT);
            $query = "INSERT INTO users (email, password) VALUES (?, ?);";
            $exec = $this->db->prepare($query);
            $exec->execute([$this->email, $this->password]);
            $query = "SELECT id FROM users WHERE email like ?;";
            $exec = $this->db->prepare($query);
            $exec->execute([$this->email]);
            $res = $exec->fetch();
            $this->id = $res["id"];
            return $res["id"];
        }

        public function read($id) {
            $this->db = \Core\Database::getDB();
            $query = "SELECT * FROM users WHERE id = ?;";
            $exec = $this->db->prepare($query);
            $exec->execute([$id]);
            $res = $exec->fetch();
            return $res;
        }

        public function update($id, $email, $password) {
            $this->db = \Core\Database::getDB();
            $query = "UPDATE users SET email = ?, password = ? WHERE id = ?;";
            $exec = $this->db->prepare($query);
            $exec->execute([$email, $password, $id]);
        }

        public function delete($id) {
            $this->db = \Core\Database::getDB();
            $query = "DELETE FROM users WHERE id = ?;";
            $exec = $this->db->prepare($query);
            $exec->execute([$id]);
        }

        */
        public function read_all() {
            $query = "SELECT * FROM " . $this->table . ";";
            $exec = $this->db->prepare($query);
            $exec->execute();
            $res = $exec->fetchAll();
            return $res;
        }

        public function save() {
            $_SESSION["password"] = $this->password;
            $_SESSION["email"] = $this->email;
            $this->password = password_hash("mon petit salt perso" .
                $this->password, PASSWORD_BCRYPT);
            $orm = new \Core\ORM();
            $_SESSION["id"] = $orm->create($this->table,
                ["email" => $this->email, "password" => $this->password]);
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

        public function check_email($email) {
            $this->db = \Core\Database::getDB();
            $this->email = $email;
            $query = "SELECT * FROM " . $this->table . " WHERE email like ?";
            $exec = $this->db->prepare($query);
            $exec->execute([$this->email]);
            $res = $exec->fetch();
            return $res;
        }

        public function verify($email, $password) {
            $this->password = $password;
            $res = $this->check_email($email);
            if (password_verify("mon petit salt perso" . $password,
                $res["password"])) {
                $_SESSION["id"] = $res["id"];
                return true;
            }
            return false;
        }

        public function getRelation() {
            return self::$relation;
        }
    }