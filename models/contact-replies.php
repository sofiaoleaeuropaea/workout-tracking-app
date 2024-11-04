<?php
require_once("base.php");

class ContactReplies extends Base
{
    public function getAllContactReplies()
    {
        $query = $this->db->prepare("
        SELECT
            contact_replies.reply_id AS reply_id,
            contact_replies.request_id AS request_id,
            contact_requests.name AS name,
            contact_requests.email AS email,
            contact_requests.message AS message,
            contact_replies.reply_message AS reply_message,
            contact_replies.reply_date AS reply_date
        FROM
            contact_replies
        JOIN
            contact_requests ON contact_replies.request_id = contact_requests.request_id
        ORDER BY
            reply_date DESC
    ");

        $query->execute();

        return $query->fetchAll();
    }

    public function getAllContactRepliesById($contactReplyId)
    {
        $query = $this->db->prepare("
        SELECT
            contact_replies.reply_id AS reply_id,
            contact_replies.request_id AS request_id,
            contact_requests.name AS name,
            contact_requests.email AS email,
            contact_requests.message AS message,
            contact_replies.reply_message AS reply_message,
            contact_replies.reply_date AS reply_date
        FROM
            contact_replies
        JOIN
            contact_requests ON contact_replies.request_id = contact_requests.request_id
        WHERE 
            contact_replies.reply_id = ?
    ");

        $query->execute([$contactReplyId]);

        return $query->fetch();
    }

    public function createContactReplies($contactReply, $requestId)
    {

        $query = $this->db->prepare("
            INSERT INTO contact_replies
           (request_id, reply_message)
            VALUES(?, ?)
        ");

        $query->execute([
            $requestId,
            $contactReply["reply_message"]
        ]);

        $contactReply['reply_id'] = $this->db->lastInsertId();

        return $contactReply;
    }
}
