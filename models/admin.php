<?php

require_once("base.php");

class Admin extends Base
{
    public function getAdminById($admin)
    {
        $query = $this->db->prepare("
            SELECT
                admin_id, name, username, email, password_hash
            FROM
                admin
            WHERE 
                admin_id = ?
        ");

        $query->execute([$admin]);

        return $query->fetch();
    }

    public function createUser($admin)
    {
        $query = $this->db->prepare("
            INSERT INTO users
           (name, username, email, password_hash)
        VALUES(?, ?, ?, ?, ?, ?, ?)
        ");

        $query->execute([
            $admin["name"],
            $admin["username"],
            $admin["email"],
            password_hash($admin["password"], PASSWORD_DEFAULT),
        ]);

        $admin['admin_id'] = $this->db->lastInsertId();

        return $admin;
    }

    public function loginAdmin($adminEmail)
    {
        $query = $this->db->prepare("
        SELECT
            admin_id, username, email, password_hash
        FROM
            admin
        WHERE 
            email = ?
    ");

        $query->execute([$adminEmail]);

        return $query->fetch();
    }

    public function deleteAdmin($admin)
    {
        $query = $this->db->prepare("
            DELETE FROM admin
            WHERE admin_id = ?
        ");

        return $query->execute([$admin]);
    }
}
