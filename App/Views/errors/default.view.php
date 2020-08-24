<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <title>Inner trouble</title>
</head>

<body>
    <h1 class="text-center">Run failed :( </h1>
    <?php if ($debug) : ?>
        <div class="alert alert-danger"><?= $error->getMessage() ?></div>
    <?php endif; ?>
</body>

</html>