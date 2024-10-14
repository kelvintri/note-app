<?php

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function redirectIfLoggedIn() {
        if (isset($_SESSION['user_id'])) {
            header("Location: ?route=home");
            exit;
        }
    }

    private function isPasswordStrong($password) {
        // Password should be at least 8 characters long and contain at least one uppercase letter,
        // one lowercase letter, and one number
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        return preg_match($pattern, $password);
    }

    public function register() {
        $this->redirectIfLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $error = "All fields are required.";
            } elseif (!$this->isPasswordStrong($password)) {
                $error = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.";
            } else {
                // Check if email already exists
                $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error = "Email already exists.";
                } else {
                    // Insert new user
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                    if ($stmt->execute([$username, $email, $hashedPassword])) {
                        // Redirect to login page
                        header("Location: ?route=login");
                        exit;
                    } else {
                        $error = "Registration failed. Please try again.";
                    }
                }
            }
        }

        // Display registration form
        ob_start();
        include __DIR__ . '/../views/auth/register.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/app.php';
    }

    public function login() {
        $this->redirectIfLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember_me = isset($_POST['remember_me']);

            if (empty($email) || empty($password)) {
                $error = "Both email and password are required.";
            } else {
                $stmt = $this->pdo->prepare("SELECT id, password FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Start session and store user ID
                    $_SESSION['user_id'] = $user['id'];
                    
                    if ($remember_me) {
                        // Generate a secure token
                        $token = bin2hex(random_bytes(32));
                        
                        // Store the token in the database
                        $stmt = $this->pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                        $stmt->execute([$token, $user['id']]);
                        
                        // Set a cookie with the token (expires in 30 days)
                        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
                    }
                    
                    // Redirect to home page
                    header("Location: ?route=home");
                    exit;
                } else {
                    $error = "Invalid email or password.";
                }
            }
        }

        // Display login form
        ob_start();
        include __DIR__ . '/../views/auth/login.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/app.php';
    }

    public function logout() {
        session_destroy();
        setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        header("Location: ?route=login");
        exit;
    }
}
