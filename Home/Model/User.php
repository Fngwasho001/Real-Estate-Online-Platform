<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register($data)
    {
        $stmt = $this->db->prepare("INSERT INTO Users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $data['full_name'], $data['email'], $data['password'], $data['role']);
        return $stmt->execute();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getById($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getAll()
    {
        $result = $this->db->query("SELECT * FROM Users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
