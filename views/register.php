<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
</head>

<body>
    <?php require("templates/navbar.php"); ?>

    <div class="container form_container_login">
        <div class="form_container form_container-w">
            <?php
            if (isset($message)) {
                echo '<p role="alert">' . $message . '</p>';
            }
            ?>
            <form method="POST" action="<?= ROOT ?>/register/" enctype="multipart/form-data">
                <div class="input_container">
                    <label class="input_label" for="input_name">Name</label>
                    <input class="input_field" id="input_name" type="text" name="name" required minlength="3" maxlength="100">
                </div>
                <div class="input_container">
                    <label class="input_label" for="input_username">Username</label>
                    <input class="input_field" id="input_username" type="text" name="username" required minlength="3" maxlength="60">
                </div>
                <div class="input_container">
                    <label class="input_label" for="input_email">Email</label>
                    <input id="input_email" class="input_field" type="email" name="email" required>
                </div>
                <div class="input_container">
                    <label class="input_label" for="input_password">Password</label>
                    <input id="input_password" class="input_field" type="password" name="password" required minlength="8" maxlength="1000">
                </div>
                <div class="input_container">
                    <label class="input_label" for="input_confirm_password">Confirm password</label>
                    <input id="input_confirm_password" class="input_field" type="password" name="password_repeat" required minlength="8" maxlength="1000">
                </div>
                <div class="input_container">
                    <label for="input_birthdate" class="input_label">Birthdate</label>
                    <input id="input_birthdate" class="input_field" type="date" name="birthdate" required>
                </div>
                <div class="input_container">
                    <label for="input_photo" class="input_label">Profile photo</label>
                    <input class="input_field" id="input_photo" type="file" name="photo" accept="image/*">
                </div>
                <div class="input_container">
                    <label>
                        <input type="checkbox" name="agrees" required>
                        I agree with the terms and conditions.
                    </label>
                </div>
                <div>
                    <button type="submit" name="register" class="btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <?php require("views/templates/footer.php"); ?>
</body>

</html>