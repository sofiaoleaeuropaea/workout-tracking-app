<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad - Calendar</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="/js/training-schedule.js"></script>

</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <h2>Training Schedule</h2>
            <section class="workout_selection form_container">
                <h3>Schedule your workouts</h3>
                <?php
                if (isset($message)) {
                    echo '<p role="alert">' . $message . '</p>';
                }
                ?>
                <form id=" add_to_calendar_form" method="POST" action="<?= ROOT ?>/gymtracker/training-schedule">
                    <div class="input_container">
                        <label for="workout_plan" class="input_label">Workout Plans:</label>
                        <select name="workout_plan_id" id="workout_plan" class="input_field" required>
                            <option value="" disabled selected>Select a workout plan</option>
                            <?php foreach ($workoutPlans as $plan): ?>
                                <option value="<?= $plan['id']; ?>">
                                    <?= $plan['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input_container">
                        <label for="calendar_date" class="input_label">Select Date:</label>
                        <input type="date" id="calendar_date" class="input_field" name="calendar_date" required>
                    </div>

                    <button type="submit" name="submit" class="btn">Add to Calendar</button>
                </form>

            </section>

            <section class="calendar_section form_container">

                <div id="calendar"></div>
            </section>
        </div>
    </main>
</body>

</html>