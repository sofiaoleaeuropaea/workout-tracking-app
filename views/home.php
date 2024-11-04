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
            <section class="hero__wrapper">
                <div class="hero__content image__background">
                    <div class="hero__content-bottom-right">
                        <h2>Start counting <br>now!</h2>
                        <p>Your journey starts here.</p>
                        <a class="btn" href="<?= ROOT ?>/register">START >></a>
                    </div>
                </div>
                <div class="hero__content">
                    <h1>Take control of <br>your training.</h1>
                    <img src="/images/woman_training.jpg" class="img-fluid hero_img" alt="Woman training outside">
                    <p>Visualize your progress with the Ironclad app. Keep track of your best sets, body fat percentage, and more.</p>
                    <a href="<?= ROOT ?>/about" class="btn_u">Read more</a>
                </div>
            </section>
        </div>
    </main>
    <?php require("views/templates/footer.php"); ?>
</body>

</html>