<div class="max-w-screen-xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Your Notes</h1>
    <input type="text" id="search" placeholder="Search notes..." class="w-full p-2 mb-4 border rounded">

    <a href="?route=create_note" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-6 inline-block">
        + Create New Note
    </a>

    <div id="notes-container" class="grid gap-4">
        <?php foreach ($notes as $note): ?>
            <div class="bg-white shadow-md rounded w-full p-4 mb-5 sm:w-[calc(50%-16px)] lg:w-[calc(25%-16px)] note-item transition duration-300 ease-in-out hover:shadow-lg hover:scale-105" data-title="<?= htmlspecialchars($note['title']) ?>" data-content="<?= htmlspecialchars($note['content']) ?>">
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
let msnry;
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('#notes-container');
    msnry = new Masonry(container, {
        itemSelector: '.note-item',
        columnWidth: '.note-item',
        percentPosition: true,
        gutter: 16
    });

    document.getElementById('search').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.note-item').forEach(note => {
            const title = note.dataset.title.toLowerCase();
            const content = note.dataset.content.toLowerCase();
            note.style.display = (title.includes(searchTerm) || content.includes(searchTerm)) ? '' : 'none';
        });
        msnry.layout();
    });

    document.querySelectorAll('.note-item').forEach(note => {
    note.addEventListener('dblclick', function() {
        const range = document.createRange();
        range.selectNodeContents(this);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
    });
});
});
</script>