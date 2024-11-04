<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad Admin - Reply Request</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php require("views/templates/navbar-admin.php"); ?>
    <main>
        <div class="container">
            <div>
                <h2>Reply Request</h2>
                <section>
                    <ul>
                        <li><strong>Name:</strong> <?php echo $request['name']; ?></li>
                        <li><strong>Email:</strong> <?php echo $request['email']; ?></li>
                        <li><strong>Message:</strong> <?php echo $request['message']; ?></li>
                    </ul>
                </section>
                <section>
                    <?php
                    if (isset($message)) {
                        echo '<p role="alert">' . $message . '</p>';
                    } ?>
                    <form method="POST" action="<?php echo ROOT; ?>/admin/support/reply?request_id=<?php echo urlencode($_GET['request_id']); ?>" enctype="multipart/form-data">
                        <div class="input_container">
                            <label class="input_label" for="reply_message">Reply Message</label>
                            <textarea class="input_field" name="reply_message" id="reply_message" rows="4" cols="50"></textarea>
                        </div>
                        <button type="submit" name="reply" class="btn">Send</button>
                    </form>
                </section>
            </div>
        </div>
    </main>
</body>