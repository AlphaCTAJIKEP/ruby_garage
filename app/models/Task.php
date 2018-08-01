<?php
    namespace app\models;
    use app\core\Db;
    use \PDO;

    class Task{
        /**
         * Получаем проект по ID пользователя
         * @param integer $id <p>ID пользователя</p>
         * @return array <p>Массив с информацией о проекте</p>
         */
        public function getTaskByProject($id){
            $db = Db::connect();
            $sql = "SELECT * FROM task WHERE project_id = :project_id ORDER BY sort ASC";
            $result = $db->prepare($sql);
            $result->bindParam(':project_id',$id, PDO::PARAM_STR);
            $result->execute();
            $projectArray = [];
            $i = 0;
            while($row = $result->fetch()){
                $projectArray[$i]['id'] = $row['id'];
                $projectArray[$i]['name'] = $row['name'];
                $projectArray[$i]['project_id'] = $row['project_id'];
                $projectArray[$i]['status'] = $row['status'];
                $projectArray[$i]['order'] = $row['sort'];
                $i++;
            }
            return $projectArray;
        }


        /**
         * Получаем проект по ID проекта
         * @param integer $id <p>ID проекта</p>
         * @return array <p>Массив с информацией о проекта</p>
         */
        public function getTaskById($id){
            $db = Db::connect();
            $sql = "SELECT * FROM task WHERE id=:id";
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
        public static function createTask($data){
            $db = Db::connect();
            $sql = "INSERT INTO task (name, project_id, status, sort) VALUES (:task_name, :project_id, 0, :sort)";
            $result = $db->prepare($sql);
            $sort = self::lastOrderByProject($data['project_id']);
            $sort++;
            $result->bindParam(':task_name', $data['task_name'], PDO::PARAM_STR);
            $result->bindParam(':project_id', $data['project_id'],PDO::PARAM_STR);
            $result->bindParam(':sort', $sort,PDO::PARAM_STR);
            if($result->execute()){
                $last_id = $db->lastInsertId();
                return [
                    'order' => $sort,
                    'name' => $data['task_name'],
                    'id' => $last_id,
                    'project_id' => $data['project_id']
                ];
            }
            
        }

        /**
         * Редактирует проект с заданным id
         * @param integer $id <p>id проекта</p>
         * @param array $data <p>Массив с информацей о проекте</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public static function updateTask($id,$data){
            $db = Db::connect();
            $sql = "UPDATE task SET ";
            if(!empty($data['task_name'])){
                $sql .= "name = :name, ";
            }
            if(isset($data['task_status'])){
                $sql .= "status = :status, ";
            }
            $sql = preg_replace('/,\s$/','',$sql);
            $sql .= " WHERE id = :id";
            $result = $db->prepare($sql);
            if(!empty($data['task_name'])){
                $result->bindParam(':name',$data['task_name'],PDO::PARAM_STR);
            }
            if(isset($data['task_status'])){
                $result->bindParam(':status',$data['task_status'],PDO::PARAM_STR);
            }
            $result->bindParam(':id',$id,PDO::PARAM_STR);
            return $result->execute();
        }

        /**
         * Редактирует проект с заданным id
         * @param integer $id <p>id проекта</p>
         * @param array $data <p>Массив с информацей о проекте</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public static function updateOrderTask($data){
            $db = Db::connect();
            $sql = "UPDATE task
            SET sort = CASE id 
                               WHEN :first_id THEN :first_order 
                               WHEN :second_id THEN :second_order 
                               ELSE sort
                               END
            WHERE id IN(:first_id, :second_id)";
            $result = $db->prepare($sql);
            $result->bindParam(':first_order',$data['first_order'],PDO::PARAM_STR);
            $result->bindParam(':first_id',$data['first_id'],PDO::PARAM_STR);
            $result->bindParam(':second_order',$data['second_order'],PDO::PARAM_STR);
            $result->bindParam(':second_id',$data['second_id'],PDO::PARAM_STR);
            return $result->execute();
        }

        /**
         * Удаляем проект
         * @param integer $id <p>ID необходимого проект</p>
         * @return boolean <p>Результат выполнения метода</p>
         */
        public function deleteTask($id){
            $db = Db::connect();
            $sql = 'DELETE FROM task WHERE id=:id';
            $result = $db->prepare($sql);
            $result->bindParam(':id',$id,PDO::PARAM_STR);
            return $result->execute();
        }

        /**
         * Проверяем название проекта на длину
         * @param string $name <p>Проверяемое значение</p>
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

        /**
         * Получаем последнее значение сортировки в данном проекте
         * @param integer $id <p>id проекта в котором проверяем</p>
         * @return integer $order <p>Последнее значение сортировки</p>
         */
        public static function lastOrderByProject($id){
            $db = Db::connect();
            $sql = 'SELECT MAX(`sort`) as "sort" FROM task WHERE project_id=:project_id';
            $result = $db->prepare($sql);
            $result->bindParam(':project_id',$id,PDO::PARAM_STR);
            if($result->execute()){
                $arr = $result->fetch();
                return $arr['sort'];
            }
            else{
                return 0;
            }
        }
    }