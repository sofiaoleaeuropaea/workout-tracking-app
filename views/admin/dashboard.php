<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad Admin - Dasboard</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php require("views/templates/navbar-admin.php"); ?>
    <main>
        <div class="container">
            <div>
                <h2>Dashboard</h2>
                <header>
                    <div class="user_info">
                        <h3 class="user_name">Welcome back, <?php echo $admin['username']; ?>!</h3>
                    </div>
                </header>
                <section class="user-metrics form_container">
                    <h3 id="user-metrics">User Metrics</h3>
                    <div class="dashboard_cards">
                        <div class="card">
                            <div class="card_content">
                                <i class="material-icons ">people</i>
                                <div class="card_info">
                                    <h4>Total Users</h4>
                                    <p><?php echo $totalUsers["total_users"]; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card_content">
                                <i class="material-icons ">person_add</i>
                                <div class="card_info">
                                    <h4>New Users This Week</h4>
                                    <p><?php echo $newUsers['new_users']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>