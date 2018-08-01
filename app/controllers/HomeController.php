<?php
    use app\models\{Project,User,Task};
    use app\core\Session;

    class HomeController extends Controller{
        public function actionIndex(){
            if(User::isGuest()){
                $this->view('guest/index');
            }
            else{
                $user_id = Session::get('user_id');
                $projects = Project::getProjectsByUser($user_id);
                foreach($projects as $key => $project){
                    $projects[$key]['task'] = Task::getTaskByProject($project['id']);
                }
                $this->view('home/index',['projects' => $projects]);
            }
        }
    }