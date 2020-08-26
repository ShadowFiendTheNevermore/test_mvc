<div class="notifications">
    <?php if (count($notifications['errors']) || count($notifications['messages'])) : ?>
        <?php if (count($notifications['errors'])) : ?>
            <?php foreach ($notifications['errors'] as $reason => $errors) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <span><?= $error ?></span>
                    <?php endforeach ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (count($notifications['messages'])) : ?>
            <?php foreach ($notifications['messages'] as $reason => $messages) : ?>
                <div class="alert alert-success">
                    <?php foreach ($messages as $message) : ?>
                        <span><?= $message ?></span>
                    <?php endforeach ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>