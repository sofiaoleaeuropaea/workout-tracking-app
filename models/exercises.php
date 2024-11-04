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

    public function getExerciseById($exerciseId)
    {
        $query = $this->db->prepare("
            SELECT
                exercise_id, name, muscle_group, description
            FROM
                exercises
            WHERE 
                exercise_id = ?
        ");

        $query->execute([$exerciseId]);

        return $query->fetch();
    }

    public function createExercise($exercise)
    {
        $query = $this->db->prepare("
            INSERT INTO exercises
           (name, muscle_group, description)
        VALUES(?, ?, ?)
        ");

        $query->execute([
            $exercise["name"],
            $exercise["muscle_group"],
            $exercise["description"]
        ]);

        $exercise['exercise_id'] = $this->db->lastInsertId();

        return $exercise;
    }

    public function updateExercise($exercise_data, $id)
    {
        $query = $this->db->prepare("
        UPDATE exercises
        SET
        name = ?,
        muscle_group = ?,
        description = ?
        WHERE
         exercise_id = ?
        ");

        $query->execute([
            $exercise_data["name"],
            $exercise_data["muscle_group"],
            $exercise_data["description"],
            $id
        ]);

        $user_data["exercise_id"] = $id;

        return $id;
    }
}
