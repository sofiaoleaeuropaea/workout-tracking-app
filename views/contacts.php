<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">

</head>

<body>
    <?php require("templates/navbar.php"); ?>
    <main>
        <div class="container">
            <div>
                <div>
                    <div>
                        <h2>We would love to hear from you!</h2>
                        <p>If you have any questions or feedback, please reach out to us.</p>
                    </div>
                    <div class="form_container form_container-w">
                        <?php
                        if (isset($message)) {
                            echo '<p role="alert">' . $message . '</p>';
                        }
                        ?>
                        <form method="POST" action="<?= ROOT ?>/contacts/" enctype="multipart/form-data">
                            <div class="input_container">
                                <label class="input_label" for="input_name">Name</label>
                                <input class="input_field" id="input_name" type="text" name="name" required minlength="3" maxlength="100">
                            </div>
                            <div class="input_container">
                                <label class="input_label" for="input_email">Email</label>
                                <input id="input_email" class="input_field" type="email" name="email" required>
                            </div>
                            <div class="input_container">
                                <label class="input_label" for="plan_description">Message</label>
                                <textarea class="input_field" name="form_message" rows="4" cols="50"></textarea>
                            </div>
                            <div>
                                <button type="submit" name="submit" class="btn">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <address>
                            <a>Edifício Mirage, R. Dr. Eduardo Neves, Nº3, 1050-077 Lisboa</a>
                        </address>

                        <address>
                            <a href="mailto:support@ironclad.pt">support@ironclad.pt</a>
                        </address>

                        <address>
                            <a href="tel:+351239000000">(+351) 239000000</a>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require("views/templates/footer.php"); ?>
</body>

</html>