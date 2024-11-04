<?php
require_once("base.php");

class ContactRequests extends Base
{
    public function getAllContactRequests()
    {

        $query = $this->db->prepare("
            SELECT
                request_id, name, email, message, created_at
            FROM
                contact_requests
            ORDER BY
                created_at DESC
        ");

        $query->execute();

        return $query->fetchAll();
    }

    public function getRequestById($requestId)
    {

        $query = $this->db->prepare("
            SELECT
                request_id, name, email, message, created_at
            FROM
                contact_requests
            WHERE 
                request_id = ?
        ");

        $query->execute([$requestId]);

        return $query->fetch();
    }

    public function createContactRequest($contactRequest)
    {

        $query = $this->db->prepare("
            INSERT INTO contact_requests
           (name, email, message)
        VALUES(?, ?, ?)
        ");

        $query->execute([
            $contactRequest["name"],
            $contactRequest["email"],
            $contactRequest["form_message"]
        ]);

        $contactRequest['contact_id'] = $this->db->lastInsertId();

        return $contactRequest;
    }
}
