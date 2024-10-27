<?php
require_once __DIR__ . '/../model/User.php';

class LoginController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $username = $_POST['username_222263'];
            $password = $_POST['password_222263'];
            $role = $_POST['role']; // Menambahkan role untuk memeriksa jenis user

            // Memanggil method login pada model User berdasarkan role
            $user = null;
            if ($role === 'admin') {
                $user = $this->user->loginAdmin($username, $password);
            } else {
                $user = $this->user->login($username, $password);
            }
            echo $user;
            if ($user) {
                session_start();
                $_SESSION['user_222263'] = $user;
                $_SESSION['role'] = $role;
                $_SESSION['user_222263']['id'] = $user['id'];
                if ($role === 'admin') {
                    header("Location: /public/admin");
                } else {
                    header("Location: /public/index.php");
                }
                exit(); 
            } else {
                echo "Invalid username or password.";
            }
        }
    }

    // Fungsi signup
}

$authController = new LoginController();
$authController->login();
?>
