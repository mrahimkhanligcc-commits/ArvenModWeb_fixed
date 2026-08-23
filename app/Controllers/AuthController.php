<?php

require_once BASE_PATH . '/app/Core/Database.php';

class AuthController
{
    public function login(): void
    {
        $this->startSession();

        if ($this->isLoggedIn()) {
            header('Location: /');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
                $error = 'Please enter a valid email and password.';
            } else {
                $db = new Database();

                $stmt = $db->pdo->prepare(
                    "SELECT user_id, name, email, password_hash, role
                     FROM users
                     WHERE email = ?"
                );
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password_hash'])) {
                    session_regenerate_id(true);

                    $_SESSION['auth'] = [
                        'logged_in' => true,
                        'user_id' => (int)$user['user_id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                    ];

                    header('Location: ' . ($user['role'] === 'admin' ? '/admin' : '/'));
                    exit;
                }

                $error = 'Incorrect email or password.';
            }
        }

        $title = 'Login - Arven Online Shop';
        $view = BASE_PATH . '/app/Views/login.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function register(): void
    {
        $this->startSession();

        if ($this->isLoggedIn()) {
            header('Location: /');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please provide a valid name and email address.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must contain at least 6 characters.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Passwords do not match.';
            } else {
                $db = new Database();

                $stmt = $db->pdo->prepare("SELECT user_id FROM users WHERE email = ?");
                $stmt->execute([$email]);

                if ($stmt->fetch()) {
                    $error = 'An account with this email already exists.';
                } else {
                    $stmt = $db->pdo->prepare(
                        "INSERT INTO users (name, email, password_hash, role)
                         VALUES (?, ?, ?, 'customer')"
                    );

                    $stmt->execute([
                        $name,
                        $email,
                        password_hash($password, PASSWORD_DEFAULT)
                    ]);

                    header('Location: /login');
                    exit;
                }
            }
        }

        $title = 'Register - Arven Online Shop';
        $view = BASE_PATH . '/app/Views/register.php';
        require BASE_PATH . '/app/Views/layout.php';
    }

    public function logout(): void
    {
        $this->startSession();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: /');
        exit;
    }

    private function isLoggedIn(): bool
    {
        return !empty($_SESSION['auth']['logged_in']);
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
