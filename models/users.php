<?php
// TODO: ADD IS_ADMIN

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
                user_id, is_admin, name, username, email, password_hash, birth_date, photo
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

        $query->execute([
            0,
            $user["name"],
            $user["username"],
            $user["email"],
            password_hash($user["password"], PASSWORD_DEFAULT),
            $api_key,
            $user["birthdate"],
            $user["photo"]
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

    public function updateUser($user_data, $id)
    {
        $query = $this->db->prepare("
        UPDATE users
        SET
        name = ?,
        username = ?,
        email = ?,
        birth_date = ?, 
        photo = ?
        WHERE
         user_id = ?
        ");

        $query->execute([
            $user_data["name"],
            $user_data["username"],
            $user_data["email"],
            $user_data["birthdate"],
            $user_data["photo"],
            $id
        ]);

        $user_data["user_id"] = $id;

        return $user_data;
    }

    public function updatePassword($user_data, $id)
    {
        $query = $this->db->prepare("
        UPDATE users
        SET
        password_hash = ?
        WHERE
         user_id = ?
        ");

        $query->execute([
            password_hash($user_data, PASSWORD_DEFAULT),
            $id
        ]);

        return $id;
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
