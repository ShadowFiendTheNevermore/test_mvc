<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'components/meta.view.php' ?>
    <title>index view with data</title>
</head>

<body>
    <?php include 'navbar.view.php' ?>
    <div class="container">
        <?php if (count($notifications['errors'])) : ?>
            <?php foreach ($notifications['errors'] as $reason => $errors) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) : ?>
                        <span><?= $error ?></span>
                    <?php endforeach ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>