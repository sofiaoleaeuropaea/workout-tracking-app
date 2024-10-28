<?php

require_once("base.php");
class WorkoutTracker extends Base
{
    public function getExerciseTrackerByWorkoutPLan() {}

    public function createExerciseTracker($user, $planExerciseId, $trackerData)
    {
        $this->db->beginTransaction();

        try {

            $trackingQuery = $this->db->prepare("
            INSERT INTO exercise_tracking (plan_exercise_id, user_id, date, notes)
            VALUES (?, ?, ?, ?)
        ");

            $trackingQuery->execute([
                $planExerciseId,
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
