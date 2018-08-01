<?php 
    use app\models\User;
    /**
     * Класс Registration для регистрации пользователя
     */
    class AuthController extends Controller{

        public function actionRegister(){
            $data = [];
            $data['user_login'] = $_POST['user_login'];
            $data['user_password'] = md5($_POST['user_password']);
            $errors = false;
            if(!User::verifyLogin($data['user_login'])){
                $errors[] = 'Логин не должен быть короче 2-х символов';
            }
            if(!User::verifyPassword($data['user_password'])){
                $errors[] = 'Пароль не должен быть короче 6-и символов';
            }
            if(!User::existLogin($data['user_login'])){
                $errors[] = 'Такой логин уже существует';
            }
            if($errors === false){
                $result = !User::addUser($data);
                echo json_encode($result);
            }
            else{
                echo json_encode(['errors' => $errors]);
            }
            
        }

        public function actionLogin(){
            $data = [];
            $data['user_login'] = $_POST['user_login'];
            $data['user_password'] = md5($_POST['user_password']);
            $errors = false;
            if($user = User::getUserByLogin($data['user_login'])){
                if($user['password'] == $data['user_password']){
                    User::auth($user['id']);
                }
                else{
                    $errors[] = 'Неверный пароль';
                }
            }
            else{
                $errors[] = 'Такого пользователя не существует';
            }
            if($errors == false){
                echo json_encode(['success' => $user['login']]);
            }
            else{
                echo json_encode(['errors' => $errors]);
            }
        }

        public function actionLogout(){
            if(!User::isGuest()){
                User::logout();
                echo json_encode(['success' => 200]);
            }
        }
    }