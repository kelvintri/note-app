<?php

require_once __DIR__ . '/../models/Note.php';

class NoteController {
    private $pdo;
    private $noteModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->noteModel = new Note($pdo);
    }

    private function ensureUserIsLoggedIn() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ?route=login");
            exit;
        }
    }

    public function index() {
        $this->ensureUserIsLoggedIn();
        $userId = $_SESSION['user_id'];
        $notes = $this->noteModel->getAllForUser($userId);
        
        ob_start();
        include __DIR__ . '/../views/notes/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/app.php';
    }

    public function create() {
        $this->ensureUserIsLoggedIn();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $userId = $_SESSION['user_id'];
            
            if ($this->noteModel->create($userId, $title, $content)) {
                header("Location: ?route=home");
                exit;
            } else {
                $error = "Failed to create note.";
            }
        }
        
        ob_start();
        include __DIR__ . '/../views/notes/create.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/app.php';
    }

    public function edit($id) {
        $this->ensureUserIsLoggedIn();
        $userId = $_SESSION['user_id'];
        $note = $this->noteModel->getById($id, $userId);
        
        if (!$note) {
            header("Location: ?route=home");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            
            if ($this->noteModel->update($id, $userId, $title, $content)) {
                header("Location: ?route=home");
                exit;
            } else {
                $error = "Failed to update note.";
            }
        }
        
        ob_start();
        include __DIR__ . '/../views/notes/edit.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/layouts/app.php';
    }

    public function delete($id) {
        $this->ensureUserIsLoggedIn();
        $userId = $_SESSION['user_id'];
        
        if ($this->noteModel->delete($id, $userId)) {
            header("Location: ?route=home");
            exit;
        } else {
            $error = "Failed to delete note.";
            header("Location: ?route=home&error=" . urlencode($error));
            exit;
        }
    }
}
