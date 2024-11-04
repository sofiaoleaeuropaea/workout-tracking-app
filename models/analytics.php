<?php
require_once("base.php");

class Analytics extends Base
{
    public function getTotalUsers()
    {
        $query = $this->db->prepare("
        SELECT COUNT(user_id) AS total_users 
        FROM users
    ");

        $query->execute();

        return $query->fetch();
    }

    public function getNewUsers()
    {
        $query = $this->db->prepare("
        SELECT COUNT(user_id) AS new_users
        FROM users
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ");

        $query->execute();

        return $query->fetch();
    }

    public function getTotalExercises()
    {
        $query = $this->db->prepare("
        SELECT COUNT(exercise_id) AS total_exercises FROM exercises
    ");

        $query->execute();

        return $query->fetch();
    }

    public function getExercisesPerPage($offset, $postsPerPage)
    {
        $query = $this->db->prepare("
        SELECT  exercise_id, name, muscle_group, description FROM exercises LIMIT :offset, :postsPerPage
    ");
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);
        $query->bindValue(':postsPerPage', $postsPerPage, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll();
    }
}
