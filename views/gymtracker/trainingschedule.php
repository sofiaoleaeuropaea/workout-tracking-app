<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad - Calendar</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/calendar.js" defer></script>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.2/main.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.2/main.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <h2>Training Schedule</h2>
            <section class="workout_selection">
                <h3>Schedule your workouts</h3>
                <?php
                if (isset($message)) {
                    echo '<p role="alert">' . $message . '</p>';
                }
                ?>
                <form id="add_to_calendar_form" method="POST" action="<?= ROOT ?>/gymtracker/trainingschedule">
                    <div class="input_container">
                        <label for="workout_plan">Workout Plans:</label>
                        <select name="workout_plan_id" id="workout_plan" required>
                            <option value="" disabled selected>Select a workout plan</option>
                            <?php foreach ($workoutPlans as $plan): ?>
                                <option value="<?= $plan['id']; ?>">
                                    <?= $plan['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input_container">
                        <label for="calendar_date">Select Date:</label>
                        <input type="date" id="calendar_date" name="calendar_date" required>
                    </div>

                    <button type="submit" name="submit" class="btn">Add to Calendar</button>
                </form>

            </section>

            <section class="calendar_section">
                <h3>Your Calendar</h3>
                <div id="calendar"></div>
            </section>
        </div>
    </main>
</body>

</html>