<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad - Login</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <div class="container">
        <div class="form_container form_container-w">
            <?php
            if (isset($message)) {
                echo '<p role="alert">' . $message . '</p>';
            }
            ?>
            <form method="POST" action="<?= ROOT ?>/gymtracker/login/">
                <div class="input_container">
                    <label for="input_email" class="input_label">Email</label>
                    <input id="input_email" class="input_field" type="email" name="email" required>
                </div>
                <div class="input_container">
                    <label for="input_password" class="input_label">Password</label>
                    <input id="input_password" class="input_field" type="password" name="password" required minlength="8" maxlength="1000">
                </div>
                <div>
                    <button type="submit" name="submit" class="btn">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>