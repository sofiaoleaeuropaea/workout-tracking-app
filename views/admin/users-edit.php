<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad Admin - Edit User</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php require("views/templates/navbar-admin.php"); ?>
    <main>
        <div class="container">
            <div>
                <h2>Edit User</h2>
                <section>
                    <?php
                    if (isset($message)) {
                        echo '<p role="alert">' . $message . '</p>';
                    } ?>
                    <form method="POST" action="<?php echo ROOT; ?>/admin/users-management/edit?user_id=<?php echo urlencode($_GET['user_id']); ?>" enctype="multipart/form-data">
                        <div>
                            <?php
                            if (!empty($user["photo"])) {
                                echo '<img src="' . ROOT . $user["photo"] . '" alt="Profile Photo" class="profile-photo">';
                            }
                            ?>
                            <input type="file" name="photo" accept="image/*">
                        </div>
                        <div class="input_container">
                            <label for="input_name" class="input_label">Name</label>
                            <input id="input_name" class="input_field" type="text" name="name" required minlength="3" maxlength="100" value="<?php echo $user['name']; ?>">
                        </div>
                        <div class="input_container">
                            <label for="input_username" class="input_label">Username</label>
                            <input id="input_username" class="input_field" type="text" name="username" required minlength="3" maxlength="60" value="<?php echo $user['username']; ?>">
                        </div>
                        <div class="input_container">
                            <label for="input_email" class="input_label">Email</label>
                            <input id="input_email" class="input_field" type="email" name="email" required value="<?php echo $user['email']; ?>">
                        </div>
                        <div class="input_container">
                            <label for="input_date" class="input_label">Birthdate</label>
                            <input id="input_date" class="input_field" type="date" name="birthdate" required value="<?php echo $user['birth_date']; ?>">
                        </div>
                        <div>
                            <button type="submit" name="edit_profile" class="btn">Edit profile</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
</body>