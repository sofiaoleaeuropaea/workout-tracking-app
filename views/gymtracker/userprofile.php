<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My account</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <div class="userprofile_container">
                <div class="form_container">
                    <?php
                    if (isset($message_profile)) {
                        echo '<p role="alert">' . $message_profile . '</p>';
                    }
                    echo '
                    <form method="POST" action="' . ROOT . '/gymtracker/userprofile/" enctype="multipart/form-data">
                    <div>';

                    if (!empty($user["photo"])) {
                        echo '<img src="' . ROOT . '/' . $user["photo"] . '" alt="Profile Photo" class="profile-photo">';
                    }

                    echo '<input type="file" name="photo" accept="image/*">
                    </div>
                     <div class="input_container">
                        <label for="input_name" class="input_label">Name</label>
                            <input id="input_name" class="input_field" type="text" name="name" required minlength="3" maxlength="100" value="' . $user["name"] . '">
                    </div>
                     <div class="input_container">
                        <label for="input_username" class="input_label">Username</label>
                            <input id="input_username" class="input_field" type="text" name="username" required minlength="3" maxlength="60" value="' . $user["username"] . '">   
                    </div>
                     <div class="input_container">
                        <label for="input_email" class="input_label">Email</label>
                            <input id="input_email" class="input_field" type="email" name="email" required value="' . $user["email"] . '">
                    </div>
                         <div class="input_container">
                        <label for="input_date" class="input_label">Birthdate</label>
                            <input id="input_date" class="input_field" type="date" name="birthdate" required value="' . $user["birth_date"] . '">
                    </div>
                    <div>
                        <button type="submit" name="edit_profile" class="btn">Edit profile</button>
                    </div>
                </form>';
                    ?>
                </div>
                <div class="form_container">
                    <?php
                    if (isset($message)) {
                        echo '<p role="alert">' . $message . '</p>';
                    }
                    echo '
                <form method="POST" action="' . ROOT . '/gymtracker/userpassword/" enctype="multipart/form-data">
                    <div class="input_container">
                        <label for="input_current_password" class="input_label">Current Password</label>
                        <input id="input_current_password" class="input_field" type="password" name="current_password" minlength="8" maxlength="1000" placeholder="********">
                    </div>
                    <div class="input_container">
                        <label for="input_new_password" class="input_label">New password</label>
                        <input id="input_new_password" class="input_field" type="password" name="new_password" minlength="8" maxlength="1000">
                    </div>
                    <div class="input_container">
                        <label for="input_password" class="input_label">Confirm password</label>
                        <input id="input_password" class="input_field" type="password" name="password_repeat" minlength="8" maxlength="1000">
                    </div>
                    <div>
                        <button type="submit" name="edit_password" class="btn">Change password</button>
                    </div></form>';
                    ?>
                </div>
            </div>
            <div>
                <a href="<?= ROOT ?> " class="btn">Delete account</a>
            </div>
        </div>
    </main>
</body>

</html>