<?php
namespace App\Models;
use PDO;
use PDOException;

class UserModel {
    private $db;

    public function __construct() {
        $dbPath = __DIR__ . '/../../config/database.sqlite';
        $this->db = new PDO('sqlite:' . $dbPath);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->createTableIfNotExists();
    }

    public function createTableIfNotExists() {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            uuid TEXT UNIQUE NOT NULL,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $this->db->exec($query);
    }

    public function createUser($uuid, $name, $email, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (uuid, name, email, password) VALUES (:uuid, :name, :email, :password)");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        return $stmt->execute();
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUser($uuid) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE uuid = :uuid");
        $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR); // Certifique-se de que $uuid é uma variável
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($uuid, $name, $email, $password) {
        $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE uuid = :uuid");
        $stmt->bindParam(':uuid', $uuid);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        return $stmt->execute();
    }

    public function deleteUser($uuid) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE uuid = :uuid");
        $stmt->bindParam(':uuid', $uuid);
        return $stmt->execute();
    }

    public function emailExists($email)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}