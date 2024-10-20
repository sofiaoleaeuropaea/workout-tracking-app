<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad dashboard</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/workoutplan.js" defer></script>
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <section>
                <div class="form_container">
                    <p id="message" role="alert"></p>
                    <form method="POST" action="<?= ROOT ?>/gymtracker/workoutplans/" enctype="multipart/form-data" id="workout_plan_form">
                        <div class="input_container">
                            <input class="input_field" type="text" name="plan_name" required minlength="3" maxlength="100" placeholder="Workout plan name">
                        </div>
                        <div class="input_container">
                            <textarea class="input_field" id="input_plan-description" name="plan_description" rows="4" cols="50">Your plan description</textarea>
                        </div>
                        <div>
                            <div id="exercise_list">
                                <div class="exercise_item">
                                    <select name="exercise_name" class="input_field" required>
                                        <option value="" disabled selected>Select an exercise</option>
                                        <?php foreach ($exercises as $exercise) : ?>
                                            <option value="<?= $exercise['exercise_id']; ?>">
                                                <?= $exercise['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <label for="sets">Sets:</label>
                                    <input type="number" id="sets" name="sets" min="1" required>

                                    <label for="reps">Reps:</label>
                                    <input type="number" id="reps" name="reps" min="1" required>

                                    <button type="button" class="remove_exercise btn">X</button>
                                </div>
                            </div>

                            <button type="button" id="add_exercise" class="btn">Add Exercise</button>
                        </div>
                        <div>
                            <button type="submit" name="save" class="btn">Save</button>
                            <button type="button" name="cancel" class="btn">Cancel</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>