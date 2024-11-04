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
            <section>
                <div class="about_wrapper">
                    <h2>What <span class="text_highlight">IRONCLAD</span> is about</h2>
                    <p>Welcome to your ultimate workout companion! The Ironclad app is designed to help you stay motivated, organized, and accountable on your fitness journey. Whether you’re a beginner or a seasoned athlete, our app provides the tools you need to reach your fitness goals.</p>

                    <a class="btn" href="<?= ROOT ?>/register">Start >></a>
                </div>
            </section>
            <section id="features_section">
                <div class="features_container">
                    <img src="/images/runtrack.jpg" class="img-fluid" alt="Runtrack">
                    <h3>Our features</h3>
                    <div class="features_wrapper">
                        <div class="features_content">
                            <h4>Workout Tracker</h4>
                            <p>Easily record your workouts, track exercises, sets, reps, and weights for optimal performance analysis.</p>
                        </div>
                        <div class="features_content">
                            <h4>Custom Workouts</h4>
                            <p>Create your personalized workouts tailored to your fitness level and goals, making each session effective and enjoyable.</p>
                        </div>
                        <div class="features_content">
                            <h4>Training Schedule</h4>
                            <p>Plan and schedule your workouts to ensure consistency and stay on track with your fitness regimen.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php require("views/templates/footer.php"); ?>
</body>

</html>