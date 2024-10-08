<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
</head>

<body>
    <?php require("templates/navbar.php"); ?>
    <div class="container">
        <form method="POST" action="<?= ROOT ?>/login/">

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
                <button type="submit" name="submit" class="btn">Login</button>
            </div>
        </form>
    </div>
</body>

</html>