<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-6">Register</h2>
    <?php if (isset($error)): ?>
        <p class="text-red-500 mb-4"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="?route=register" method="POST">
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
            <input type="text" id="username" name="username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" id="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-6">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" id="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            <p id="password-strength" class="text-sm mt-1"></p>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:shadow-outline">
            Register
        </button>
    </form>
    <p class="mt-4 text-center">
        Already have an account? <a href="?route=login" class="text-blue-500 hover:text-blue-700">Login</a>
    </p>
</div>

<script>
document.getElementById('password').addEventListener('input', function() {
    var password = this.value;
    var strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;

    var strengthElement = document.getElementById('password-strength');
    switch (strength) {
        case 0:
        case 1:
            strengthElement.textContent = 'Weak';
            strengthElement.className = 'text-sm mt-1 text-red-500';
            break;
        case 2:
        case 3:
            strengthElement.textContent = 'Medium';
            strengthElement.className = 'text-sm mt-1 text-yellow-500';
            break;
        case 4:
            strengthElement.textContent = 'Strong';
            strengthElement.className = 'text-sm mt-1 text-green-500';
            break;
    }
});
</script>
