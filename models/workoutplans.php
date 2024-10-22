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

    public function getWorkoutPlansDetails($plan)
    {
        $query = $this->db->prepare("
        SELECT 
            wp.plan_id AS id, wp.name AS plan_name, wp.description AS description, pe.plan_exercise_id, pe.exercise_order, pe.target_sets, pe.target_reps, e.exercise_name
        FROM 
            workout_plans AS wp
        LEFT JOIN 
            plan_exercises AS pe ON wp.plan_id = pe.plan_id
        LEFT JOIN 
            exercises AS e ON pe.exercise_id = e.exercise_id
        WHERE 
            wp.plan_id = ?
        ");

        $query->execute([$plan]);

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
                    $exercise['sets'],
                    $exercise['reps']
                ]);
            }

            $this->db->commit();

            return $plan['plan_id'];
        } catch (PDOException $error) {
            $this->db->rollBack();
            throw $error;
        }
    }
}
