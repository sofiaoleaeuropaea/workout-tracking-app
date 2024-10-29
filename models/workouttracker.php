<?php

require_once("base.php");
class WorkoutTracker extends Base
{
    public function getExerciseTrackerByWorkoutPlan($planId)
    {
        $query = $this->db->prepare("
       SELECT 
            wp.plan_id AS plan_id, 
            wp.name AS plan_name, 
            pe.plan_exercise_id AS plan_exercise_id, 
            pe.exercise_id AS exercise_id, 
            pe.exercise_order AS exercise_order,
            e.name AS exercise_name,
            et.tracking_id AS tracking_id,
            et.date AS tracking_date,
            et.notes AS tracking_notes,
            es.set_id AS set_id,
            es.set_number AS set_number,
            es.reps AS reps,
            es.weight AS weight
        FROM 
            workout_plans AS wp
        LEFT JOIN 
            plan_exercises AS pe ON wp.plan_id = pe.plan_id
        LEFT JOIN 
            exercises AS e ON pe.exercise_id = e.exercise_id
        LEFT JOIN 
            exercise_tracking AS et ON pe.plan_id = wp.plan_id
        LEFT JOIN 
            exercise_sets AS es ON et.tracking_id = es.tracking_id
        WHERE 
            wp.plan_id = ?
        ORDER BY 
            et.tracking_id, es.set_number;
    ");

        $query->execute([$planId]);

        return $query->fetchAll();
    }

    public function createExerciseTracker($user, $planId, $trackerData)
    {
        $this->db->beginTransaction();

        try {

            $trackingQuery = $this->db->prepare("
            INSERT INTO exercise_tracking (plan_id, user_id, date, notes)
            VALUES (?, ?, ?, ?)
        ");

            $trackingQuery->execute([
                $planId,
                $user,
                $trackerData['date'],
                $trackerData['notes']
            ]);

            $trackingId = $this->db->lastInsertId();


            foreach ($trackerData['exercisesTracker'] as $exerciseId => $sets) {
                foreach ($sets as $index => $set) {
                    $setQuery = $this->db->prepare("
                        INSERT INTO exercise_sets (tracking_id, exercise_id, set_number, reps, weight)
                        VALUES (?, ?, ?, ?, ?)
                    ");

                    $setQuery->execute([
                        $trackingId,
                        $exerciseId,
                        $index + 1,
                        $set['reps'],
                        $set['weight']
                    ]);
                }
            }
            $this->db->commit();

            return $trackingId;
        } catch (PDOException $error) {
            $this->db->rollBack();
            throw $error;
        }
    }
}
