<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
$pdo = require_once __DIR__ . '/../config/database.php';

// Check for remember_token cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE remember_token = ?");
    $stmt->execute([$_COOKIE['remember_token']]);
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
    }
}

// Simple routing
$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'home':
        require_once __DIR__ . '/../src/controllers/NoteController.php';
        $controller = new NoteController($pdo);
        $controller->index();
        break;
    case 'login':
        require_once __DIR__ . '/../src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->login();
        break;
    case 'register':
        require_once __DIR__ . '/../src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->register();
        break;
    case 'logout':
        require_once __DIR__ . '/../src/controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->logout();
        break;
    case 'create_note':
        require_once __DIR__ . '/../src/controllers/NoteController.php';
        $controller = new NoteController($pdo);
        $controller->create();
        break;
    case 'edit_note':
        require_once __DIR__ . '/../src/controllers/NoteController.php';
        $controller = new NoteController($pdo);
        $controller->edit($_GET['id']);
        break;
    case 'delete_note':
        require_once __DIR__ . '/../src/controllers/NoteController.php';
        $controller = new NoteController($pdo);
        $controller->delete($_GET['id']);
        break;
    default:
        echo "404 Not Found";
        break;
}
