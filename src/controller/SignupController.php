<?php
require_once __DIR__ . '/../model/User.php';

class SignupController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
            $fullname = $_POST['fullname_222263'];
            $username = $_POST['username_222263'];
            $email = $_POST['email_222263'];
            $password = $_POST['password_222263'];
            $confirm_password = $_POST['confirm_password'];

            // Validasi jika password dan konfirmasi password cocok
            if ($password !== $confirm_password) {
                echo 'Passwords do not match.';
                return;
            }

            // Hash password untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Panggil method signup pada model User
            $user = $this->user->signup($fullname, $username, $email, $hashed_password);

            if ($user) {  // Periksa jika signup berhasil
                session_start();
                $_SESSION['user'] = $user;

                // Redirect ke halaman login
                header('Location: /public/login');
                exit();  // Pastikan untuk menghentikan eksekusi skrip setelah redirect
            } else {
                echo 'Signup failed. Please try again.';
            }
        }
    }
}

$authController = new SignupController();
$authController->signup();
?>
