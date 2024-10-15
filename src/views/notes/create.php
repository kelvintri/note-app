<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-6">Create New Note</h2>
    <?php if (isset($error)): ?>
        <p class="text-red-500 mb-4"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="?route=create_note" method="POST">
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input type="text" id="title" name="title" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
        </div>
        <div class="mb-6">
            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
            <textarea id="content" name="content" rows="4" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            <i class="fas fa-save mr-2"></i>Create Note
        </button>
    </form>
</div>
