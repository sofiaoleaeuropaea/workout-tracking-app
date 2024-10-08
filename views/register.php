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
    <div class="container">
        <form method="POST" action="<?= ROOT ?>/register/" enctype="multipart/form-data">
            <div>
                <label>
                    Name
                    <input type="text" name="name" required minlength="3" maxlength="100">
                </label>
            </div>
            <div>
                <label>
                    Username
                    <input type="text" name="username" required minlength="3" maxlength="60">
                </label>
            </div>
            <div>
                <label>
                    Email
                    <input type="email" name="email" required>
                </label>
            </div>
            <div>
                <label>
                    Password
                    <input type="password" name="password" required minlength="8" maxlength="1000">
                </label>
            </div>
            <div>
                <label>
                    Confirm password
                    <input type="password" name="password_confirm" required minlength="8" maxlength="1000">
                </label>
            </div>
            <div>
                <label>
                    Birthdate
                    <input type="date" name="birthdate" required>
                </label>
            </div>
            <div>
                <label>
                    Profile photo
                    <input type="file" name="profile_photo" accept="image/*">
                </label>
            </div>
            <div class="field">
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
</body>

</html>