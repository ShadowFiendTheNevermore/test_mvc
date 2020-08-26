<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'components/meta.view.php' ?>
    <title>index view with data</title>
</head>

<body>
    <header>
        <?php include 'navbar.view.php' ?>
    </header>
    <main style="padding: 15px">
        <div class="container">
            <?php if (isset($notifications)) include 'components/notifications.view.php' ?>
            <div class="row">
                <div class="col-md-12">
                    <form class="form" method="POST" action="/jobs/<?= $action ?><?php if (isset($job)) echo '?job_id=' . $job['id'] ?>">
                        <div class="form-group">
                            <input value="<?php if (isset($job)) echo $job['email'] ?>" text" name="email" placeholder="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <input value="<?php if (isset($job)) echo $job['username'] ?>" type="text" name="username" placeholder="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea name="text" class="form-control" placeholder="text of job"><?php if (isset($job)) echo $job['text'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" name="is_done" type="checkbox" value="1" <?= $job['is_done'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="defaultCheck1">
                                    completed
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>