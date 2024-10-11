<?php
// VER COMO FAZER COM A QUESTÃO DO IS_ADMIN
// UPDATE USER??
require_once("base.php");

class Users extends Base
{
    public function getAllUsers()
    {
        $query = $this->db->prepare("
            SELECT
                user_id, is_admin, username
            FROM
                users
        ");

        $query->execute();

        return $query->fetchAll();
    }

    public function getUserById($user)
    {
        $query = $this->db->prepare("
            SELECT
                user_id, is_admin, name, username, email, birth_date
            FROM
                users
            WHERE 
                user_id = ?
        ");

        $query->execute([$user]);

        return $query->fetch();
    }

    public function getByUsername($username)
    {
        $query = $this->db->prepare("
        SELECT
            user_id, username
        FROM
            users
        WHERE 
            username = ?
    ");

        $query->execute([$username]);

        return $query->fetch();
    }

    public function getByEmail($email)
    {
        $query = $this->db->prepare("
        SELECT
            user_id, email
        FROM
            users
        WHERE 
            email = ?
    ");

        $query->execute([$email]);

        return $query->fetch();
    }

    public function createUser($user)
    {
        $api_key = bin2hex(random_bytes(16));

        $query = $this->db->prepare("
            INSERT INTO users
           (is_admin, name, username, email, password_hash, refresh_token, birth_date, photo)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?)
        ");
        // mudar o valor hardcoded de is_admin e a photo
        $query->execute([
            0,
            $user["name"],
            $user["username"],
            $user["email"],
            password_hash($user["password"], PASSWORD_DEFAULT),
            $api_key,
            $user["birthdate"],
            null
        ]);

        $user['user_id'] = $this->db->lastInsertId();

        return $user;
    }

    public function loginUser($user)
    {
        $query = $this->db->prepare("
        SELECT
            user_id, username, password_hash
        FROM
            users
        WHERE 
            email = ?
    ");

        $query->execute([$user]);

        return $query->fetch();
    }

    public function deleteUser($user)
    {
        $query = $this->db->prepare("
            DELETE FROM users
            WHERE user_id = ?
        ");

        return $query->execute([$user]);
    }
}
