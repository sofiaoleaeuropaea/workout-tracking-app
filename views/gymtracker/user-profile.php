<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad - My account</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/user-delete.js" defer></script>
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <div class="userprofile_container">
                <?php
                if (isset($message)) {
                    echo '<p role="alert">' . $message . '</p>';
                } ?>
                <div class="form_container">
                    <?php
                    if (isset($messageProfile)) {
                        echo '<p role="alert">' . $messageProfile . '</p>';
                    }
                    echo '
                    <form method="POST" action="' . ROOT . '/gymtracker/user-profile/" enctype="multipart/form-data">
                        <div>';

                    if (!empty($user["photo"])) {
                        echo '<img src="' . ROOT . $user["photo"] . '" alt="Profile Photo" class="profile-photo">';
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

                    if (isset($messageUpdatePassword)) {
                        echo '<p role="alert">' . $messageUpdatePassword . '</p>';
                    }
                    echo '
                <form method="POST" action="' . ROOT . '/gymtracker/user-password/" enctype="multipart/form-data">
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
            <div class="delete_account_wrapper">
                <button id="delete_account_btn" class="btn">Delete account</button>
            </div>

            <div id="delete_account_modal" class="modal" style="display: none;">
                <div class="modal_content">

                    <span class="close_modal">&times;</span>
                    <h2>Confirm Account Deletion</h2>
                    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                    <form id="delete_account_form" method="POST" action="<?= ROOT ?>/gymtracker/user-delete/">
                        <div class="input_container">
                            <label for="confirm_password" class="input_label">Confirm Password</label>
                            <input id="confirm_password" class="input_field" type="password" name="confirm_password" required minlength="8" maxlength="1000" placeholder="********">
                        </div>
                        <p role="alert" id="delete_error_message" style="color: red;" hidden></p>

                        <div>
                            <button type="submit" name="delete_user" class="btn">Confirm Deletion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>