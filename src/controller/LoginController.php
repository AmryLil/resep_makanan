<?php
require_once __DIR__ . '/../model/User.php';

class LoginController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $username = $_POST['username_222263'];
            $password = $_POST['password_222263'];
            $role = $_POST['role'];

            // Validasi password (minimal 8 karakter)
            if (strlen($password) < 8) {
                $_SESSION['errors'][] = 'Password harus terdiri dari minimal 8 karakter.';
            }

            // Memanggil method login hanya jika tidak ada kesalahan
            if (!isset($_SESSION['errors'])) {
                $user = null;
                if ($role === 'admin') {
                    $user = $this->user->loginAdmin($username, $password);
                } else {
                    $user = $this->user->login($username, $password);
                }

                if ($user) {
                    $_SESSION['user_222263'] = $user;
                    $_SESSION['role'] = $role;
                    $_SESSION['user_222263']['id'] = $user['id'];
                    if ($role === 'admin') {
                        header('Location: /public/admin');
                    } else {
                        header('Location: /public/index.php');
                    }
                    exit();
                } else {
                    $_SESSION['errors'][] = 'Invalid username or password.';
                }
            }

            // Redirect kembali ke login jika ada error
            header('Location: /public/login');
            exit();
        }
    }
}

$authController = new LoginController();
$authController->login();
?>
