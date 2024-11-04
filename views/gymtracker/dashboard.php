<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad - Dashboard</title>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">

</head>

<body>
    <?php require("views/templates/navbar.php"); ?>
    <main>
        <div class="container">
            <header>
                <div class="user_info">
                    <img src="<?php echo $user['photo']; ?>" alt="<?php echo $user['username']; ?>" class="user_photo-small">
                    <h2 class="user_name">Welcome back, <?php echo $user['username']; ?>!</h2>
                </div>
            </header>
            <section class="form_container exercise_label">
                <?php if (!empty($exercises)): ?>
                    <h3>Today's plan </h3>
                    <h4><?php echo $exercises[0]['plan_name']; ?></h4>
                    <ul class="exercise-list">
                        <?php foreach ($exercises as $exercise): ?>
                            <li class="exercise-item">
                                <span><?php echo $exercise['exercise_order']; ?>.</span> <?php echo $exercise['exercise_name']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div>
                        <h3>Today's plan</h3>
                        <p>Time to take a break! No exercises on today’s schedule.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
</body>

</html>