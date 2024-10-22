<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad - Workout Plan</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/workoutplan.js" defer></script>
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <div class="workout_plan_container">
                <section class="workout_plan_form">
                    <div class="form_container">
                        <h2>Create your workout</h2>
                        <?php
                        if (isset($message)) {
                            echo '<p role="alert">' . $message . '</p>';
                        } ?>
                        <form id="workout_form" method="POST" action="<?= ROOT ?>/gymtracker/createworkout/" enctype="multipart/form-data">
                            <div class="input_container">
                                <label class="input_label" for="plan_name">Workout Plan Name:</label>
                                <input class="input_field" type="text" id="plan_name" name="plan_name" required minlength="3" maxlength="100">
                            </div>
                            <div class="input_container">
                                <label class="input_label" for="plan_description">Workout Plan Description:</label>
                                <textarea class="input_field" id="plan_description" name="plan_description" rows="4" cols="50"></textarea>
                            </div>
                            <div>
                                <div id="exercise_list">
                                    <div class="exercise_item">
                                        <label class="input_label" for="workout_exercises">Select Exercises:</label>
                                        <select class="input_field" name="exercises[0][exercise_id]" id="workout_exercises" required>
                                            <option value="" disabled selected>Select an exercise</option>
                                            <?php foreach ($exercises as $exercise) : ?>
                                                <option value="<?= $exercise['exercise_id']; ?>">
                                                    <?= $exercise['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <label for="sets">Sets:</label>
                                        <input type="number" id="sets" name="exercises[0][sets]" min="1" required>

                                        <label for="reps">Reps:</label>
                                        <input type="number" id="reps" name="exercises[0][reps]" min="1" required>

                                        <button type="button" class="remove_exercise btn">X</button>
                                    </div>
                                </div>

                                <button type="button" id="add_exercise" class="btn">Add Exercise</button>
                            </div>
                            <div>
                                <button type="submit" name="save" class="btn">Save</button>
                                <button type="button" id="btn_cancel" name="cancel" class="btn">Cancel</button>
                            </div>
                        </form>
                    </div>
                </section>
                <section class="workout_plan_list">

                    <h3>Your Workout Plans</h3>

                    <?php if (!empty($workoutPlans)): ?>
                        <ul>
                            <?php foreach ($workoutPlans as $plan): ?>
                                <li class="workout_plan">
                                    <a href="<?= ROOT ?>/gymtracker/userworkouts.php?id=<?php echo $plan['id']; ?>">
                                        <?php echo $plan['name']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No workout plans found.</p>
                    <?php endif; ?>

                </section>
            </div>
        </div>
    </main>
</body>

</html>