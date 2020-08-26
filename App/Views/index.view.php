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
            <?php include 'components/notifications.view.php' ?>
            <?php if (isset($jobs)) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs nav-fill">
                            <?php foreach ($jobs['filters'] as $filterKey => $filter) : ?>
                                <li class="nav-item">
                                    <?php if (isset($_GET['sort']) && $_GET['sort'] === $filterKey) : ?>
                                        <a class="nav-link active" href="<?= $filter['link'] ?>"><?= $filter['name'] ?></a>
                                    <?php else : ?>
                                        <a class="nav-link" href="<?= $filter['link'] ?>"><?= $filter['name'] ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $jobs['reverse_link'] ?>">Reverse</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <?php foreach ($jobs['data'] as $job) : ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2><?= $job['email'] ?></h2>
                                            <h3><?= $job['username'] ?></h3>
                                        </div>
                                        <div class="card-body">
                                            <p><?= $job['text'] ?></p>
                                        </div>
                                        <div class="card-footer">
                                            <?php if ($job['is_done']) : ?>
                                                Status : <span class="badge badge-success">completed</span>
                                            <?php else : ?>
                                                Status : <span class="badge badge-secondary">In process</span>
                                            <?php endif; ?>
                                            <?php if ($job['is_changed']) : ?>
                                                Approved : <span class="badge badge-success">changed</span>
                                            <?php else : ?>
                                                Approved : <span class="badge badge-secondary">Await</span>
                                            <?php endif; ?>

                                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']) : ?>
                                                <a href="/jobs/change?job_id=<?= $job['id'] ?>" class="btn btn-primary">Change me</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 12px">
                    <div class="col-md-12">
                        <?php if ($jobs['pages'] > 1) {
                            $pagination = $jobs;
                            include 'components/pagination.view.php';
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row" style="margin-top: 12px">
                <div class="col-md-12">
                    <a href="jobs/create" class="btn btn-success">Создать задачу</a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>