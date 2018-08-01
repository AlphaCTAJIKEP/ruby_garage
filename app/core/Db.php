<?php
    namespace app\core;
    use PDO;
    class Db{

        public static function connect(){
            try{
                $connect = self::open();
                if($connect){
                    return $connect;
                }
                else{
                    return false;
                }
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
            }
        }

        private static function open(){
            try{
                $dsn = 'mysql:dbname=rubygarage; host=localhost';
                $user = 'root';
                $pasword = '';

                $options = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC,
                );
                $db = new \PDO($dsn, $user, $password, $options);
                return $db;
            }
            catch (PDOException $e) 
            {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
    }