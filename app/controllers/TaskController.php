<?php
    use app\models\{Task,User};
    use app\core\Session;
    
    class TaskController extends Controller{

        public function actionTaskadd(){
            $data = [];
            $errors = false;
            if(isset( $_POST['task_name'])){
                $data['task_name'] = $_POST['task_name'];
            }
            if(isset( $_POST['project_id'])){
                $data['project_id'] = $_POST['project_id'];
            }
            if(!Task::verifyName( $data['task_name'])){
                $errors[] = 'Неверное название задачи';
            }
            $result = Task::createTask($data);
            if(!$errors){
                echo json_encode($result);
            }
            else{
                echo json_encode(['errors' => $errors]);
            }
        }

        public function actionTaskdelete(){
            if(isset($_POST['task_id']) && !User::isGuest()){
                if(Task::deleteTask($_POST['task_id'])){
                    echo json_encode(['id' => $_POST['task_id']]);
                }
                else{
                    echo json_encode(['errors' => 'Ошибка удаления']);
                }

            }
        }

        public function actionTaskorder(){
            $data = [];
            if(isset( $_POST['first_id'])){
                $data['first_id'] = $_POST['first_id'];
            }
            if(isset( $_POST['first_order'])){
                $data['first_order'] = $_POST['first_order'];
            }
            if(isset( $_POST['second_id'])){
                $data['second_id'] = $_POST['second_id'];
            }
            if(isset( $_POST['second_order'])){
                $data['second_order'] = $_POST['second_order'];
            }
            $result = Task::updateOrderTask($data);
            echo json_encode($result);
        }

        public function actionEdittask(){
            $data = [];
            $errors = false;
            if(isset($_POST['task_id'])){
                $id = $_POST['task_id'];
            }
            if(isset($_POST['task_name'])){
                $data['task_name'] = $_POST['task_name'];
                if(!Task::verifyName($data['task_name'])){
                    $errors[] = 'Неверное название задачи';
                }
            }
            if(isset($_POST['task_status'])){
                $data['task_status'] = $_POST['task_status'];
            }
            if(!User::isGuest()){
               $result = Task::updateTask($id,$data);
               if(!$result){
                   $errors[] = 'Ошибка обновления';
               }
            }
            if($errors){
                echo json_encode(['errors' => $errors]);   
            }
            else{
                echo json_encode(['name' => $data['task_name'], 'id'=>$id]);
            }
        }
    }