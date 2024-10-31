<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad - Workout Tracker</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/workouttracker.js" defer></script>
    <script src="/js/workouttrackerdetails.js" defer></script>
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>

    <main>
        <div class="container">
            <div class="form_container">
                <h2>Gym Tracker</h2>
                <?php
                if (isset($message)) {
                    echo '<p role="alert">' . $message . '</p>';
                } ?>
                <form id="gym_tracker_form" method="POST"
                    action="<?= ROOT . '/gymtracker/workouttracker/' ?>"
                    enctype="multipart/form-data">
                    <div class="workout_plan_details">
                        <div class="input_container">
                            <label class="input_label" for="workout_plan">Select Workout Plan:</label>
                            <select class="input_field" id="workout_plan" name="workout_plan" required>
                                <option value="" disabled selected>Select a workout plan</option>
                                <?php foreach ($workoutPlans as $plan) : ?>
                                    <option value="<?= $plan['id']; ?>"><?= $plan['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input_container">
                            <label class="input_label" for="date">Date:</label>
                            <input class="input_field" type="date" id="date" name="date" required>
                        </div>
                    </div>
                    <div id="exercise-tracker_list" class="exercise-tracker_list">
                    </div>
                    <div class="input_container">
                        <label class="input_label" for="notes">Notes:</label>
                        <textarea class="input_field" id="notes" name="notes" rows="4" cols="50" placeholder="Leave your notes here..."></textarea>
                    </div>

                    <button type="submit" name="submit" class="btn">Submit</button>
                </form>
            </div>
            <div>
                <h2>Previous Workouts</h2>
                <select class="input_field" id="get_plan_tracker" name="get_plan_tracker" required>
                    <option value="" disabled selected>Select a workout plan</option>
                    <?php foreach ($workoutPlans as $plan) : ?>
                        <option value="<?= $plan['id']; ?>"><?= $plan['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <div id="plan-tracker_card"></div>

            </div>

        </div>
    </main>
</body>

</html>