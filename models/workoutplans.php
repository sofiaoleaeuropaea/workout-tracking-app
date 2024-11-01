<?php

require_once("base.php");
class WorkoutPlans extends Base
{
    public function getWorkoutPlansById($user)
    {
        $query = $this->db->prepare("
        SELECT
            plan_id AS id, name
        FROM
            workout_plans
        WHERE 
            user_id = ?
        ORDER BY 
            created_at DESC
    ");

        $query->execute([$user]);

        return $query->fetchAll();
    }

    public function getWorkoutPlansDetails($planId)
    {
        $query = $this->db->prepare("
        SELECT 
            wp.plan_id AS plan_id, 
            wp.name AS plan_name, 
            wp.description AS plan_description, 
            pe.plan_exercise_id AS plan_exercise_id, 
            pe.exercise_id AS exercise_id, 
            pe.exercise_order AS exercise_order, 
            pe.target_sets AS target_sets, 
            pe.target_reps AS target_reps, 
            e.name AS exercise_name
        FROM 
            workout_plans AS wp
        LEFT JOIN 
            plan_exercises AS pe ON wp.plan_id = pe.plan_id
        LEFT JOIN 
            exercises AS e ON pe.exercise_id = e.exercise_id
        WHERE 
            wp.plan_id = ?
    ");

        $query->execute([$planId]);

        return $query->fetchAll();
    }

    public function createWorkoutPlan($user, $plan)
    {
        $this->db->beginTransaction();

        try {
            $plan_query = $this->db->prepare("
            INSERT INTO workout_plans (user_id, name, description)
            VALUES (?, ?, ?)
        ");

            $plan_query->execute([
                $user,
                $plan["plan_name"],
                $plan["plan_description"]
            ]);

            $plan['plan_id'] = $this->db->lastInsertId();

            foreach ($plan['exercises'] as $index => $exercise) {
                $exercise_query = $this->db->prepare("
                    INSERT INTO plan_exercises (plan_id, exercise_id, exercise_order, target_sets, target_reps)
                    VALUES (?, ?, ?, ?, ?)
                ");

                $exercise_query->execute([
                    $plan['plan_id'],
                    $exercise['exercise_id'],
                    $index + 1,
                    $exercise['target_sets'],
                    $exercise['target_reps']
                ]);
            }

            $this->db->commit();

            return $plan['plan_id'];
        } catch (PDOException $error) {
            $this->db->rollBack();
            throw $error;
        }
    }


    public function updateWorkoutPlan($planData, $userID, $planId)
    {
        try {
            $this->db->beginTransaction();

            $query = $this->db->prepare("
            UPDATE workout_plans
            SET
                name = ?,
                description = ?
            WHERE
                plan_id = ? AND user_id = ?
        ");
            $query->execute([
                $planData["plan_name"],
                $planData["plan_description"],
                $planId,
                $userID
            ]);

            foreach ($planData["exercises"] as $index => $exercise) {
                $exerciseQuery = $this->db->prepare("
                UPDATE plan_exercises 
                SET
                exercise_id = ?, target_sets = ?, target_reps = ?
                 WHERE
                plan_id = ? AND exercise_order = ?
            ");
                $exerciseQuery->execute([
                    $exercise['exercise_id'],
                    $exercise['target_sets'],
                    $exercise['target_reps'],
                    $planId,
                    $exercise['exercise_order']
                ]);
            }

            $this->db->commit();
            return $planId;
        } catch (PDOException $error) {
            $this->db->rollBack();
            echo $error->getMessage();
            throw $error;
        }
    }

    public function deleteWorkoutPlan($planId)
    {
        $deleteQuery = $this->db->prepare("
            DELETE FROM workout_plans
            WHERE plan_id = ?
        ");

        return $deleteQuery->execute([$planId]);
    }
}
