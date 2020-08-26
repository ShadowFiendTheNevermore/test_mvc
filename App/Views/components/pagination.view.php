<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php if (isset($pagination['previous'])) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pagination['previous'] ?>">Previous</a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <a class="page-link">Previous</a>
            </li>
        <?php endif; ?>
        <?php for ($i = 1; $i < $pagination['pages'] + 1; $i++) : ?>
            <li class="page-item <?php if ($pagination['current_page'] === $i) echo 'active' ?>">
                <a class="page-link" href="<?= $pagination['plain'] . $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
        <?php if (isset($pagination['next'])) : ?>
            <li class="page-item"><a class="page-link" href="<?= $pagination['next'] ?>">Next</a></li>
        <?php else : ?>
            <li class="page-item disabled"><a class="page-link">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>