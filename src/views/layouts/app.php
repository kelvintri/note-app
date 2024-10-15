<?php
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note Taking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex flex-col min-h-screen bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div>
                    <a href="?route=home" class="font-semibold text-gray-500 text-lg">
                        <i class="fas fa-sticky-note mr-2"></i>Note App
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="?route=home" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-home mr-2"></i>Home
                        </a>
                        <form action="?route=logout" method="POST">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="?route=login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="?route=register" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto mt-4 p-4">
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-6xl mx-auto py-4 px-4 text-center">
            <p>&copy; 2023 Note Taking App. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
