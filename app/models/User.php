<?php   
    namespace app\models;
    use app\core\{Db,Session};
    use \PDO;
    /**
     * Класс User для работы с пользователями
     */
    class User{
        
        public function getUserById($id){
            $db = Db::connect();
            $sql = "SELECT * FROM users WHERE id = :id";
            $query = $db->prepare($sql);
            $query->bindParam(':id',$id, PDO::PARAM_STR);
            $query->execute();
            return $query->fetch();
        }

        public function getUserByLogin($login){
            $db = Db::connect();
            $sql = "SELECT * FROM users WHERE login = :login";
            $query = $db->prepare($sql);
            $query->bindParam(':login',$login, PDO::PARAM_STR);
            $query->execute();
            return $query->fetch();
        }

        public static function isGuest(){
            if (Session::get('isLogged')) {
                return false;
            }
            return true;
        }

        public static function verifyLogin($login){
            $login = trim($login);
            if(strlen($login) < 2){
                return false;
            }
            else{
                return true;
            }
        }

        public static function auth($userId){
            Session::set('isLogged',true);
            Session::set('user_id',$userId);
        }

        public static function logout(){
            Session::set('isLogged',false);
            Session::destroy();
        }

        public static function verifyPassword($password){
            if(strlen($password) < 6){
                return false;
            }
            else{
                return true;
            }
        }

        public static function existLogin($login){
            $user = self::getUserByLogin($login);
            if($user){
                return false;
            }
            else{
                return true;
            }
        }

        public static function addUser($data){
            $db = Db::connect();
            $sql = "INSERT INTO users (login, password) VALUES (:login, :password)";
            $result = $db->prepare($sql);
            $result->bindParam(':login', $data['user_login'], PDO::PARAM_STR);
            $result->bindParam(':password', $data['user_password'],PDO::PARAM_STR);
            return $result->execute();
        }
    }