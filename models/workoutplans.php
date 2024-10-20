<?php

require_once("base.php");

class WorkoutPlans extends Base
{
    public function createWorkoutPlan($user, $plan)
    {
        $this->db->beginTransaction();

        try {
            $plan_query = $this->db->prepare("
                INSERT INTO workout_plan
                (user_id, name, description)
                VALUES(?, ?, ?)
            ");

            $plan_query->execute([
                $user,
                $plan["plan_name"],
                $plan["plan_description"]
            ]);

            $plan['plan_id'] = $this->db->lastInsertId();

            if (isset($plan['exercises'])) {
                foreach ($plan['exercises'] as $index => $exercise) {
                    $exercise_query = $this->db->prepare("
                        INSERT INTO plan_exercises
                        (plan_id, exercise_id, exercise_order, target_sets, target_reps)
                        VALUES(?, ?, ?, ?, ?)
                    ");

                    $exercise_query->execute([
                        $plan['plan_id'],
                        $exercise['exercise_id'],
                        $index + 1,
                        $exercise['sets'],
                        $exercise['reps']
                    ]);
                }
            }

            $this->db->commit();

            return  $plan['plan_id'];
        } catch (Exception $error) {

            $this->db->rollBack();
            throw $error;
        }
    }
    // public function createWorkoutPlan($user, $plan)
    // {
    //     $query = $this->db->prepare("
    //         INSERT INTO workout_plans
    //         (user_id, name, description)
    //         VALUES(?, ?, ?)
    //     ");

    //     $query->execute([
    //         $user,
    //         $plan["plan_name"],
    //         $plan["plan_description"]
    //     ]);

    //     $plan['plan_id'] = $this->db->lastInsertId();

    //     if(isset($plan["exercises"])){

    //     }
    //     return $plan;
    // }
}
