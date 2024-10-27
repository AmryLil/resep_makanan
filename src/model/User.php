<?php
require_once __DIR__ . '/../config/db.php';

class User {
    private $conn;
    private $table_name = "users_222263";
    private $table_nameAdmin = "admin_222263";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Fungsi login untuk user
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username_222263 = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi password yang terenkripsi
        if ($user && password_verify($password, $user['password_222263'])) {
            return $user;
        }

        return false;
    }

    // Fungsi login untuk admin
    public function loginAdmin($username, $password) {
        $query = "SELECT * FROM " . $this->table_nameAdmin . " WHERE username_222263 = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verifikasi password biasa tanpa enkripsi
        if ($admin && $password === $admin['password_222263']) {
            return $admin;
        }
    
        return false;
    }
    
    // Fungsi signup untuk user
    public function signup($fullname, $username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table_name . " (fullname_222263, username_222263, email_222263, password_222263) VALUES (:fullname, :username, :email, :password)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
    
        try {
            if ($stmt->execute()) {
                return $this->login($username, $password); // otomatis login setelah signup
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return false;
        }
        return false;
    }
}
