<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad Admin - Create Exercise</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php require("views/templates/navbar-admin.php"); ?>
    <main>
        <div class="container">
            <div>
                <h2>Create Exercise</h2>
                <section>
                    <?php
                    if (isset($message)) {
                        echo '<p role="alert">' . $message . '</p>';
                    } ?>
                    <form method="POST" action="<?php echo ROOT; ?>/admin/workout-library/create" enctype="multipart/form-data">

                        <div class="input_container">
                            <label for="input_name" class="input_label">Name</label>
                            <input id="input_name" class="input_field" type="text" name="name" required minlength="3" maxlength="150">
                        </div>
                        <div class="input_container">
                            <label for="input_name" class="input_label">Muscle Group</label>
                            <input id="input_name" class="input_field" type="text" name="muscle_group" required minlength="3" maxlength="50">
                        </div>
                        <div class="input_container">
                            <label class="input_label" for="plan_description">Description</label>
                            <textarea class="input_field" name="description" rows="4" cols="50"></textarea>
                        </div>
                        <div>
                            <button type="submit" name="create_exercise" class="btn">Create exercise</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
</body>