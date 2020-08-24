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
            <div class="row">
                <?php foreach ($notifications['errors'] as $reason => $errors) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) : ?>
                            <span><?= $error ?></span>
                        <?php endforeach ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (count($notifications['messages'])) : ?>
            <div class="row">
                <?php foreach ($notifications['messages'] as $reason => $messages) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($messages as $message) : ?>
                            <span><?= $message ?></span>
                        <?php endforeach ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-4">
                <?php foreach ($jobs['data'] as $job) : ?>
                    <div class="card">
                        <div class="card-body">
                            <?= $job['email'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>