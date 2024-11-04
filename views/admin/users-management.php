<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad Admin - Users Management</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="/js/admin/users-delete.js" defer></script>
</head>

<body>
    <?php require("views/templates/navbar-admin.php"); ?>
    <main>
        <div class="container">
            <div>
                <h2>Users management</h2>
                <section class="form_container">
                    <div role="alert" class="alert_message">
                        <?php
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>
                    </div>

                    <table class="set_list_table">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                        <?php

                        if (!empty($users)) {

                            foreach ($users as $user) {
                                $encryptedId = $encryptionUtility->encryptId($user["user_id"]);

                                echo "
              <tr>
                <td>{$user["user_id"]}</td>
                <td>{$user["username"]}</td>
                <td>{$user["email"]}</td>
                <td>{$user["created_at"]}</td>
                <td>{$user["created_at"]}</td>
                <td> 
                    <a href='/admin/users-management/edit?user_id=" . urlencode($encryptedId) . "'
                        <i class='material-icons' style='font-size: 16px;'>edit</i>
                    </a>
                </td>
                <td>
                  <button data-user-id='{$user["user_id"]}' class='btn remove_btn' type='btn'>&times;</button>
                </td>
              </tr>
              ";
                            }

                        ?>
                            <tr>
                    </table>
                <?php
                        } else {
                            echo "<p>There are no users registered yet.</p>";
                        }
                ?>
                </section>
            </div>
        </div>
    </main>
</body>