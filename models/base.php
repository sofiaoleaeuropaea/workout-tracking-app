<?php
class Base
{

    protected $db;

    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=" . ENV["DB_HOST"] . ";port=" . ENV["DB_PORT"] . ";dbname=" . ENV["DB_NAME"] . ";charset=utf8mb4",
            ENV["DB_USER"],
            ENV["DB_PASSWORD"],
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_STRINGIFY_FETCHES => false
            ]
        );
    }
}
