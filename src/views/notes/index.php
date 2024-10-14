<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Your Notes</h1>
    
    <a href="?route=create_note" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
        Create New Note
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($notes as $note): ?>
            <div class="bg-white shadow-md rounded px-6 pt-6 pb-4 flex flex-col h-full">
                <div class="flex-grow">
                    <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($note['title']) ?></h2>
                    <p class="text-gray-700 mb-4"><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                </div>
                <div class="flex justify-between mt-4">
                    <a href="?route=edit_note&id=<?= $note['id'] ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                    <form action="?route=delete_note&id=<?= $note['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
