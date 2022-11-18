<div class="show">
    <?php $note = $params['note'] ?? null;?>
    <?php if($note) : ?>
        <ul>
            <li>Tytuł: <?php echo $note['title']?></li>
            <li><?php echo $note['description']?></li>
            <li>Utworzono: <?php echo $note['created']?></li>
        </ul>
        </a>
        <?php else: ?>
            <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>
    <a href="/">
        <button>Powrót do listy notatek</button>
    </a>
</div>