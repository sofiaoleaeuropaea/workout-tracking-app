<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad Admin - Workout Library</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php require("views/templates/navbar-admin.php"); ?>
    <main>
        <div class="container">
            <div>
                <h2>Workout Library</h2>

                <section>
                    <a href="/admin/workout-library/create" class="btn">Add Exercise</a>
                    <div class="form_container">
                        <table class="set_list_table">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Muscle Group</th>
                                <th>Description</th>
                                <th>Edit</th>
                            </tr>
                            <?php

                            if (!empty($exercises)) {

                                foreach ($exercises as $exercise) {

                                    $encryptedId = $encryptionUtility->encryptId($exercise["exercise_id"]);

                                    echo "
              <tr>
                <td>{$exercise["exercise_id"]}</td>
                <td>{$exercise["name"]}</td>
                <td>{$exercise["muscle_group"]}</td>
                <td>{$exercise["description"]}</td>
                <td>
                  <a href='/admin/workout-library/edit?exercise_id=" . urlencode($encryptedId) . "'
                        <i class='material-icons' style='font-size: 16px;'>edit</i>
                    </a>
                </td>
              </tr>
              ";
                                }

                            ?>
                                <tr>
                        </table>
                        <div class="pagination">
                            <?php if ($currentPage > 1): ?>
                                <a href="/admin/workout-library/?page=<?php echo $currentPage - 1; ?>" class="btn-slider">Previous</a>
                            <?php endif; ?>

                            <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                                <?php if ($page === $currentPage): ?>
                                    <strong><?php echo $page; ?></strong>
                                <?php else: ?>
                                    <a href="/admin/workout-library/?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="/admin/workout-library/?page=<?php echo $currentPage + 1; ?>" class="btn-slider">Next</a>
                            <?php endif; ?>
                        </div>
                    <?php
                            } else {
                                echo "<p>There are no exercises created.</p>";
                            }
                    ?>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>