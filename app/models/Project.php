<?php 
    namespace app\models;
    use app\core\Db;
    use \PDO;
    /**
     * Класс Project для работы с проектами
     */
    class Project{

        /**
         * Получаем проект по ID пользователя
         * @param integer $id <p>ID пользователя</p>
         * @return array <p>Массив с информацией о проекте</p>
         */
        public function getProjectsByUser($user_id){
            $db = Db::connect();
            $sql = "SELECT * FROM project WHERE user_id = :user_id";
            $result = $db->prepare($sql);
            $result->bindParam(':user_id',$user_id, PDO::PARAM_STR);
            $result->execute();
            $projectArray = [];
            $i = 0;
            while($row = $result->fetch()){
                $projectArray[$i]['id'] = $row['id'];
                $projectArray[$i]['name'] = $row['name'];
                $projectArray[$i]['user_id'] = $row['user_id'];
                $i++;
            }
            return $projectArray;
        }


        /**
         * Получаем проект по ID проекта
         * @param integer $id <p>ID проекта</p>
         * @return array <p>Массив с информацией о проекта</p>
         */
        public function getProjectById($id){
            $db = Db::connect();
            $sql = "SELECT * FROM project WHERE id=:id";
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        }

        /**
         * Создаем новый проект
         * @param array $data <p>Массив данных о проекте</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public function createProject($data){
            $db = Db::connect();
            $sql = "INSERT INTO project (name, user_id) VALUES (:name, :user_id)";
            $result = $db->prepare($sql);
            $result->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $result->bindParam(':user_id', $data['user_id'],PDO::PARAM_STR);
            $result->execute();
            return $db->lastInsertId();
        }

        /**
         * Редактирует проект с заданным id
         * @param integer $id <p>id проекта</p>
         * @param array $data <p>Массив с информацей о проекте</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public function updateProject($id,$data){
            $db = Db::connect();
            $sql = "UPDATE project SET name = :name WHERE id = :id";
            $result = $db->prepare($sql);
            $result->bindParam(':name',$data['project_name'],PDO::PARAM_STR);
            $result->bindParam(':id',$id,PDO::PARAM_STR);
            return $result->execute();
        }

        /**
         * Удаляем проект
         * @param integer $id <p>ID необходимого проект</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public function deleteProject($id){
            $db = Db::connect();
            $sql = 'DELETE FROM project WHERE id=:id';
            $result = $db->prepare($sql);
            $result->bindParam(':id',$id,PDO::PARAM_STR);
            return $result->execute();
        }

        /**
         * Проверяем название проекта на длину
         * @param strin $name <p>Проверяемое значение</p>
         * @return boolean <p>Результат проверки</p>
         */
        public static function verifyName($name){
            $name = trim($name);
            if(strlen($name) < 2){
                return false;
            }
            else{
                return true;
            }
        }
    }