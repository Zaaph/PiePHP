<?php

    namespace Controller;

    class UserController extends \Core\Controller 
    {

        public function registerAction() {
            $params = $this->request->getQueryParams();
            $user = new \Model\UserModel($params);
            if (!isset($user->id)) {
                if (empty($user->check_email($params["email"]))) {
                    if (preg_match("/\w+@\w+\.\w+/", $params["email"]) === 1) {
                        $user->save();
                        header("Location: /PiePHP/user");
                    }
                    self::$_render = "Veuillez entrer un email valide." .
                        PHP_EOL;
                    return;
                }
                self::$_render = "Cet email est déjà utilisé." . PHP_EOL;
                return;
            }
            self::$_render = "Une erreur s'est produite!" . PHP_EOL;
        }

        public function loginAction() {
            $params = $this->request->getQueryParams();
            $model = new \Model\UserModel($params);
            if ($model->verify($params["email"], $params["password"])) {
                $_SESSION["email"] = $params["email"];
                $_SESSION["password"] = $params["password"];
                header("Location: /PiePHP/user");
            } else {
                self::$_render = "Identifiants incorrect, veuillez réessayer" .
                    PHP_EOL;
            }
        }

        public function readAction($id) {
            $model = new \Model\UserModel([]);
            $res = $model->read($id);
            return $res;
        }

        public function infoPageAction() {
            $this->render("User/infoPage");
        }

        public function modifierAction() {
            $params = $this->request->getQueryParams();
            $user = new \Model\UserModel($params);
            if (!isset($user->id)) {
                if (empty($user->check_email($params["email"]))) {
                    if (preg_match("/\w+@\w+\.\w+/", $params["email"]) === 1) {
                        if ($user->update($_SESSION["id"],
                            ["email" => $params["email"], "password" => 
                            password_hash("mon petit salt perso" .
                                $params["password"], PASSWORD_BCRYPT)])) {
                            $this->session_update($params["email"],
                                $params["password"]);
                            header("Location: /PiePHP/user");
                        }
                    }
                    self::$_render = "Veuillez entrer un email valide." .
                        PHP_EOL;
                    return;
                }
                self::$_render = "Cet email est déjà utilisé" . PHP_EOL;
                return;
            }
            self::$_render = "Une erreur s'est produite!" . PHP_EOL;
        }

        public function deconnectAction() {
            unset($_SESSION["email"]);
            unset($_SESSION["password"]);
            header("Location: /PiePHP/");
        }

        public function deleteAction() {
            $params = $this->request->getQueryParams();
            $model = new \Model\UserModel($params);
            if ($model->delete($_SESSION["id"])) {
                self::$_render = "Votre compte a bien été supprimé.";
                $this->deconnectAction();
            } else {
                self::$_render = "Une erreur s'est produite.";
            }
        }

        public function session_update($email, $password) {
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
        }
    }