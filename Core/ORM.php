<?php

    namespace Core;

    class ORM
    {
        private $db;

        public function __construct() {
            $this->db = \Core\Database::getDB();
        }

        public function create($table, $fields) {
            $query = "INSERT INTO " . $table . " (";
            end($fields);
            $last_key = key($fields);
            reset($fields);
            foreach ($fields as $key => $value) {
                $query .= $key;
                if ($key === $last_key) {
                    $query .= ") VALUES (";
                } else {
                    $query .= ", ";
                }
            }
            foreach ($fields as $key => $value) {
                $query .= "\"" . $value . "\"";
                if ($key === $last_key) {
                    $query .= ");";
                } else {
                    $query .= ", ";
                }
            }
            $exec = $this->db->prepare($query);
            if (!$exec->execute()) {
                return false;
            }
            return $this->get_last_id()["id"];
        }

        public function get_last_id() {
            $query = "SELECT LAST_INSERT_ID() AS 'id';";
            $exec = $this->db->prepare($query);
            $exec->execute();
            $res = $exec->fetch();
            return $res;
        }

        public function read($table, $id) {
            $class = "\\Model\\" . ucfirst($table) . "Model";
            $query = "SELECT * FROM " . $table . " WHERE id = ?";
            $exec = $this->db->prepare($query);
            if (!$exec->execute([$id])) {
                return false;
            }
            $res = $exec->fetch();
            if (class_exists($class)) {
                $model = new $class(array());
                $relation = $model->getRelation();
            }
            if (isset($relation) && !empty($relation) && $res) {
                $this->relation_handler($table, $id, $res, $relation);
            }
            return $res;
        }

        public function relation_handler($table, $id, &$res, $relation) {
            $matches = array();
            foreach ($relation as $value) {
                if (preg_match("/has many (.+)/", $value, $matches)) {
                    $class = "\\Model\\" . ucfirst($matches[1]) . "Model";
                    if (class_exists($class)) {    
                        $model = new $class(array());
                    }
                    if (!$this->many_to_many($table, $id, $res, $matches)) {
                        $res[$matches[1]] = $this->find($matches[1],
                            ["WHERE" => $table . "_id = " . $id,
                            "ORDER BY" => "id ASC", "LIMIT" => ""]);
                    }
                } elseif (preg_match("/has one (.+)/", $value, $matches)) {
                    $one_id = $this->find($table, ["WHERE" => "id = " . $id,
                        "ORDER BY" => "id ASC",
                        "LIMIT" => ""])[0][$matches[1] . "_id"];
                    $res[$matches[1]] = $this->find($matches[1],
                        ["WHERE" => "id = " . $one_id,
                        "ORDER BY" => "id ASC", "LIMIT" => ""]);
                }
            }
        }

        public function many_to_many($table, $id, &$res, $matches) {
            $class = "\\Model\\" . ucfirst($matches[1]) . "Model";
            if (class_exists($class)) {    
                $model = new $class(array());
                $relation = $model->getRelation();
            }
            foreach ($relation as $value) {
                if ($value === "has many " . $table) {
                    $query = "SELECT *, " . $matches[1] . ".id AS relate_id" . 
                        " FROM " . $matches[1] . " LEFT JOIN ";
                    if ($table > $matches[1]) {
                        $pivot = $matches[1] . "_" . $table;
                    } else {
                        $pivot = $table . "_" . $matches[1];
                    }
                    $query .= $pivot . " ON " . $pivot . "." . $matches[1] .
                        "_id = " . $matches[1] . ".id LEFT JOIN " . $table .
                        " ON " . $pivot . "." . $table . "_id = " . $table .
                        ".id WHERE " . $table . ".id = " . $id;
                    $exec = $this->db->prepare($query);
                    $exec->execute();
                    $res[$matches[1]] = $exec->fetchAll();
                    return true;
                }
            }
            return false;
        }

        public function update($table, $id, $fields) {
            $query = "UPDATE " . $table . " SET ";
            end($fields);
            $last_key = key($fields);
            reset($fields);
            foreach ($fields as $key => $value) {
                $query .= $key . " = \"" . $value . "\"";
                if ($key !== $last_key) {
                    $query .= ", ";
                }
            }
            $query .= " WHERE id = ?;";
            $exec = $this->db->prepare($query);
            if ($exec->execute([$id])) {
                return true;
            }
            return false;
        }

        public function delete($table, $id) {
            $query = "DELETE FROM " . $table . " WHERE id = ?";
            $exec = $this->db->prepare($query);
            if ($exec->execute([$id])) {
                return true;
            }
            return false;
        }
        
        public function find ($table, $params = array(
            "WHERE" => "1",
            "ORDER BY" => "id ASC",
            "LIMIT" => ""
        )) {
            $query = "SELECT * FROM " . $table . " WHERE " . $params["WHERE"]
                . " ORDER BY " . $params["ORDER BY"];
            if ($params["LIMIT"] !== "") {
                $query .= "LIMIT " . $params["LIMIT"];
            }
            $query .= ";";
            $exec = $this->db->prepare($query);
            if (!$exec->execute()) {
                return false;
            }
            $res = $exec->fetchAll();
            return $res;
        }
    }

?>