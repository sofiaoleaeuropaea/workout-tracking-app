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
    <script src="/js/deleteworkout.js" defer></script>
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <div class="workout_plan_container">
                <section class="workout_plan_form">
                    <a href="<?= ROOT ?>/gymtracker/createworkout/" class="btn">Create New Plan</a>
                    <div class="form_container">
                        <h2><?php echo isset($planId) ? 'Edit your workout' : 'Create your workout'; ?></h2>
                        <?php if (isset($message)) {
                            echo '<p role="alert">' . $message . '</p>';
                        } ?>

                        <form id="workout_form" method="POST"
                            action="<?= isset($planId) ? ROOT . '/gymtracker/createworkout/?edit_plan_id=' . $planId : ROOT . '/gymtracker/createworkout/' ?>"
                            enctype="multipart/form-data">
                            <?php if (isset($planId)) {
                                echo '<input type="hidden" name="plan_id" value="' . $planId . '">';
                            } ?>
                            <div class="input_container">
                                <label class="input_label" for="plan_name">Name:</label>
                                <input class="input_field" type="text" id="plan_name" name="plan_name" required minlength="3" maxlength="100" value="<?= isset($planName) ? $planName : ''; ?>">
                            </div>
                            <div class="input_container">
                                <label class="input_label" for="plan_description">Description:</label>
                                <textarea class="input_field" id="plan_description" name="plan_description" rows="4" cols="50"><?= isset($planDescription) ? $planDescription : ''; ?></textarea>
                            </div>
                            <div>
                                <div id="exercise_list">
                                    <?php if (isset($existingExercises) && count($existingExercises) > 0): ?>
                                        <?php foreach ($existingExercises as $index => $exercise): ?>
                                            <div class="exercise_item">
                                                <label class="input_label" for="exercise_id_<?= $index; ?>">Select Exercises:</label>
                                                <select class="input_field" name="exercises[<?= $index ?>][exercise_id]" id="exercise_id_<?= $index; ?>" required>
                                                    <option value="" disabled <?= empty($exercise['exercise_id']) ? 'selected' : ''; ?>>Select an exercise</option>
                                                    <?php foreach ($exercises as $availableExercise): ?>
                                                        <option value="<?= $availableExercise['exercise_id']; ?>" <?= ($availableExercise['exercise_id'] == $exercise['exercise_id']) ? 'selected' : ''; ?>>
                                                            <?= $availableExercise['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>

                                                <label for="sets_<?= $index; ?>" class="input_label">Target Sets:</label>
                                                <input type="number" class="input_field" id="sets_<?= $index; ?>" name="exercises[<?= $index ?>][sets]" min="1" value="<?= $exercise['sets']; ?>" required>

                                                <label for="reps_<?= $index; ?>" class="input_label">Target Reps:</label>
                                                <input type="number" class="input_field" id="reps_<?= $index; ?>" name="exercises[<?= $index ?>][reps]" min="1" value="<?= $exercise['reps']; ?>" required>
                                                <input type="hidden" name="exercises[<?= $index ?>][exercise_order]" value="<?= $index + 1; ?>">

                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="exercise_item">
                                            <label class="input_label" for="workout_exercises">Select Exercises:</label>
                                            <select class="input_field" name="exercises[0][exercise_id]" id="workout_exercises" required>
                                                <option value="" disabled selected>Select an exercise</option>
                                                <?php foreach ($exercises as $exercise): ?>
                                                    <option value="<?= $exercise['exercise_id']; ?>">
                                                        <?= $exercise['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="sets" class="input_label">Target Sets:</label>
                                            <input type="number" class="input_field" id="sets" name="exercises[0][sets]" min="1" required>

                                            <label for="reps" class="input_label">Target Reps:</label>
                                            <input type="number" class="input_field" id="reps" name="exercises[0][reps]" min="1" required>
                                            <input type="hidden" name="exercises[0][exercise_order]" value="0">

                                            <button type="button" class="remove_exercise btn">&times;</button>
                                        </div>
                                        <button type="button" id="add_exercise" class="btn">Add Exercise</button>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div>
                                <button type="submit" name="save" class="btn"><?= isset($planId) ? 'Update' : 'Save'; ?></button>
                                <?php
                                if (isset($planId)) {
                                    echo '<button type="button" id="btn_delete" name="delete" class="btn">Delete</button>';
                                } else {
                                    echo '<button type="button" id="btn_cancel" name="cancel" class="btn">Cancel</button>';
                                }
                                ?>

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
                                    <a href="<?= ROOT ?>/gymtracker/createworkout/?edit_plan_id=<?= $plan['id']; ?>">
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