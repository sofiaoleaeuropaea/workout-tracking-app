<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad - Workout Plan</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/create-workout.js" defer></script>
    <script src="/js/delete-workout.js" defer></script>
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <div class="workout_plan_container">
                <section class="workout_plan_form">
                    <a href="/gymtracker/create-workout/" class="btn">Create New Plan</a>
                    <?php if (isset($planId)): ?>
                        <div class="form_container">
                            <h2>Edit your Workout</h2>

                            <?php if (isset($message)): ?>
                                <p role="alert"><?= $message; ?></p>
                            <?php endif; ?>

                            <form id="workout_form_update" method="POST" action="<?= ROOT . '/gymtracker/create-workout/update?plan_id=' . $planId ?>" enctype="multipart/form-data">
                                <input type="hidden" name="plan_id" value="<?= $planId; ?>">

                                <div class="input_container">
                                    <label class="input_label" for="plan_name">Name:</label>
                                    <input class="input_field" type="text" id="plan_name" name="plan_name" required minlength="3" maxlength="100" value="<?= $planName; ?>">
                                </div>

                                <div class="input_container">
                                    <label class="input_label" for="plan_description">Description:</label>
                                    <textarea class="input_field" id="plan_description" name="plan_description" rows="4" cols="50"><?= $planDescription; ?></textarea>
                                </div>

                                <div id="exercise_list_update">
                                    <p class="input_label">Exercises:</p>
                                    <?php if (isset($existingExercises) && count($existingExercises) > 0): ?>
                                        <?php foreach ($existingExercises as $index => $exercise): ?>
                                            <div class="exercise_item_update">
                                                <input type="text" id="exercise_name_<?= $index; ?>" class="input_field" value="<?= $exercise['exercise_name']; ?>" disabled>

                                                <label for="sets_<?= $index; ?>" class="input_label">Target Sets:</label>
                                                <input type="number" class="input_field" id="sets_<?= $index; ?>" name="exercises[<?= $index ?>][sets]" min="1" value="<?= $exercise['sets']; ?>" required>

                                                <label for="reps_<?= $index; ?>" class="input_label">Target Reps:</label>
                                                <input type="number" class="input_field" id="reps_<?= $index; ?>" name="exercises[<?= $index ?>][reps]" min="1" value="<?= $exercise['reps']; ?>" required>

                                                <input type="hidden" name="exercises[<?= $index ?>][exercise_order]" value="<?= $index + 1; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <button type="submit" name="update" class="btn">Update</button>
                                    <button type="button" id="btn_delete" name="delete" class="btn">Delete</button>
                                </div>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="form_container">
                            <h2>Create your Workout</h2>

                            <?php if (isset($message)): ?>
                                <p role="alert"><?= $message; ?></p>
                            <?php endif; ?>

                            <form id="workout_form" method="POST" action="<?= ROOT . '/gymtracker/create-workout/' ?>" enctype="multipart/form-data">
                                <div class="input_container">
                                    <label class="input_label" for="plan_name">Name:</label>
                                    <input class="input_field" type="text" id="plan_name" name="plan_name" required minlength="3" maxlength="100">
                                </div>

                                <div class="input_container">
                                    <label class="input_label" for="plan_description">Description:</label>
                                    <textarea class="input_field" id="plan_description" name="plan_description" rows="4" cols="50"></textarea>
                                </div>

                                <div id="exercise_list">
                                    <p class="input_label">Exercises:</p>
                                    <div class="exercise_item">
                                        <select class="input_field" name="exercises[0][exercise_id]" id="workout_exercises" required>
                                            <option value="" disabled selected>Select an exercise</option>
                                            <?php foreach ($exercises as $exercise): ?>
                                                <option value="<?= $exercise['exercise_id']; ?>">
                                                    <?= $exercise['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="exercise_item_detail">
                                            <label for="sets" class="input_label">Target Sets:</label>
                                            <input type="number" class="input_field" id="sets" name="exercises[0][sets]" min="1" required>
                                        </div>
                                        <div class="exercise_item_detail">
                                            <label for="reps" class="input_label">Target Reps:</label>
                                            <input type="number" class="input_field" id="reps" name="exercises[0][reps]" min="1" required>
                                        </div>
                                        <input type="hidden" name="exercises[0][exercise_order]" value="0">

                                        <button type="button" class="remove_exercise btn btn_w">&times;</button>
                                    </div>
                                    <button type="button" id="add_exercise" class="btn">Add Exercise</button>
                                </div>

                                <div>
                                    <button type="submit" name="save" class="btn">Save</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </section>
                <section class="workout_plan_list">
                    <h3>Your Workout Plans</h3>
                    <?php if (!empty($workoutPlans)): ?>
                        <ul>
                            <?php foreach ($workoutPlans as $plan): ?>
                                <li class="workout_plan">
                                    <a href="/gymtracker/create-workout/update?plan_id=<?= $plan['id']; ?>">
                                        <?= $plan['name']; ?>
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