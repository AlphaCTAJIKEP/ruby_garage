<?php
    use app\models\{Project,User};
    use app\core\Session;
    
    class ProjectController extends Controller{

        public function actionCreateproject(){
            $data = [];
            $errors = false;
            $user_id = Session::get('user_id');
            $data['name'] = $_POST['project-name'];
            $data['user_id'] = $user_id;
            if(!Project::verifyName( $data['name'])){
                $errors[] = 'Неверное название проекта';
            }
            $id = Project::createProject($data);
            $result['id'] = $id;
            $result['name'] = $data['name'];
            if(!$errors){
                echo json_encode($result);
            }
            else{
                echo json_encode(['errors' => $errors]);
            }
        }

        public function actionDeleteproject(){
            if(isset($_POST['project_id']) && !User::isGuest()){
                if(Project::deleteProject($_POST['project_id'])){
                    echo json_encode(['id' => $_POST['project_id']]);
                }
                else{
                    echo json_encode(['errors' => 'Ошибка удаления']);
                }

            }
        }

        public function actionEditproject(){
            $data = [];
            $errors = false;
            if(isset($_POST['project_id'])){
                $id = $_POST['project_id'];
            }
            if(isset($_POST['project_name'])){
                $data['project_name'] = $_POST['project_name'];
            }
            if(!Project::verifyName($data['project_name'])){
                $errors[] = 'Неверное название проекта';
            }
            if(!User::isGuest()){
               $result = Project::updateProject($id,$data);
               if(!$result){
                   $errors[] = 'Ошибка обновления';
               }
            }
            if($errors){
                echo json_encode(['errors' => $errors]);   
            }
            else{
                echo json_encode(['name' => $data['project_name'], 'id'=>$id]);
            }
        }
    }