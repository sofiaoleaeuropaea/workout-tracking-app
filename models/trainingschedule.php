<?php

require_once("base.php");

class trainingSchedule extends Base
{
    public function createTrainingSchedule($userId, $planId, $scheduledDate)
    {
        $schedule_query = $this->db->prepare("
            INSERT INTO training_schedule (user_id, plan_id, schedule_date, send_notification)
            VALUES (?, ?, ?, ?)
        ");

        $sendNotification = 0;

        $schedule_query->execute([
            $userId,
            $planId,
            $scheduledDate,
            $sendNotification
        ]);

        $scheduleId = $this->db->lastInsertId();

        return $scheduleId;
    }

    public function getTrainingScheduleById($userId)
    {
        $query = $this->db->prepare("
      SELECT 
            ts.schedule_id,
            ts.schedule_date,
            wp.name AS plan_name,
            wp.description AS plan_description,
            pe.plan_exercise_id,
            pe.exercise_id,
            e.name AS exercise_name
        FROM 
            training_schedule ts
        LEFT JOIN 
            workout_plans AS wp ON ts.plan_id = wp.plan_id
        LEFT JOIN 
            plan_exercises AS pe ON wp.plan_id = pe.plan_id
        LEFT JOIN 
            exercises AS e ON pe.exercise_id = e.exercise_id
        WHERE 
            ts.user_id = :user_id AND 
            ts.schedule_date = CURDATE()
     
        ");

        $query->execute(['user_id' => $userId]);
        $results = $query->fetchAll();

        return $results;
    }
}
