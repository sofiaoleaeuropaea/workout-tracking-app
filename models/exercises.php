<?php

require_once("base.php");

class Exercises extends Base
{
    public function getAllExercises()
    {
        $query = $this->db->prepare("
            SELECT
                exercise_id, name
            FROM
                exercises
        ");

        $query->execute();

        return $query->fetchAll();
    }
}
