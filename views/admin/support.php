<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ironclad Admin - Support</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php require("views/templates/navbar-admin.php"); ?>
    <main>
        <div class="container">
            <section>
                <h2>Request Messages</h2>
                <?php
                if (isset($message)) {
                    echo '<p role="alert">' . $message . '</p>';
                } ?>
                <div class="form_container">
                    <table class="set_list_table">
                        <tr>
                            <th>Request ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Created at</th>
                            <th>Reply</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        $repliedRequestIds = [];
                        if (!empty($contactReplies)) {
                            foreach ($contactReplies as $contactReplie) {
                                $repliedRequestIds[$contactReplie["request_id"]] = true;
                            }
                        }

                        if (!empty($contactRequests)) {
                            foreach ($contactRequests as $contactRequest) {
                                $encryptedId = $encryptionUtility->encryptId($contactRequest["request_id"]);

                                $status = isset($repliedRequestIds[$contactRequest["request_id"]]) ? 'Replied' : 'Pending';
                                echo "
                               <tr>
                                   <td>{$contactRequest["request_id"]}</td>
                                   <td>{$contactRequest["name"]}</td>
                                   <td>{$contactRequest["email"]}</td>
                                   <td>{$contactRequest["message"]}</td>
                                   <td>{$contactRequest["created_at"]}</td>
                                   <td> 
                                       <a href='/admin/support/reply?request_id=" . urlencode($encryptedId) . "'>
                                           <i class='material-icons' style='font-size: 16px;'>reply</i>
                                       </a>
                                   </td>
                                   <td>{$status}</td>
                               </tr>
                               ";
                            }
                        ?>
                    </table>
                <?php
                        } else {
                            echo "<p>No support messages found.</p>";
                        }
                ?>
                </div>
            </section>
            <section>
                <h2>Reply Messages</h2>
                <?php
                if (isset($message)) {
                    echo '<p role="alert">' . $message . '</p>';
                } ?>
                <div class="form_container">
                    <table class="set_list_table">
                        <tr>
                            <th>Reply ID</th>
                            <th>Request ID</th>
                            <th>Message</th>
                            <th>Reply</th>
                            <th>Reply Date</th>
                        </tr>
                        <?php
                        if (!empty($contactReplies)) {
                            foreach ($contactReplies as $contactReplie) {
                                echo "
                               <tr>
                                   <td>{$contactReplie["reply_id"]}</td>
                                   <td>{$contactReplie["request_id"]}</td>
                                   <td>{$contactReplie["message"]}</td>
                                   <td>{$contactReplie["reply_message"]}</td>
                                   <td>{$contactReplie["reply_date"]}</td>
                               </tr>
                               ";
                            }
                        ?>
                    </table>
                <?php
                        } else {
                            echo "<p>No reply messages found.</p>";
                        }
                ?>
                </div>
            </section>
        </div>
    </main>
</body>

</html>