
<style>
@media (min-width: 640px) { /* Tablet */
    #notes-container .bg-white {
        width: calc(50% - 16px); /* 50% width for tablets */
    }
}

@media (min-width: 1024px) { /* Desktop */
    #notes-container .bg-white {
        width: calc(25% - 16px); /* 25% width for desktops */
    }
}
</style>
<div class="max-w-screen-xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Your Notes</h1>

    <a href="?route=create_note" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">
        + Create New Note
    </a>

    <div id="notes-container" class="grid gap-4 auto-rows-max">
        <?php foreach ($notes as $note): ?>
            <div class="bg-white shadow-md rounded p-4 mb-5" >
                <h2 class="text-lg font-semibold mb-2"><?= htmlspecialchars($note['title']) ?></h2>
                <p class="text-gray-700 text-sm break-words"><?= nl2br(htmlspecialchars($note['content'])) ?></p>

                <div class="flex justify-between items-center mt-4">
                    <a href="?route=edit_note&id=<?= $note['id'] ?>" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="?route=delete_note&id=<?= $note['id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Include Masonry library -->
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var elem = document.querySelector('#notes-container');
    var msnry = new Masonry(elem, {
        itemSelector: '.bg-white',
        columnWidth: '.bg-white',
        percentPosition: true,
        gutter: 16 // Adjust gutter as needed
    });
});
</script>

