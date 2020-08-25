<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <?php if (isset($_SESSION['user'])) : ?>
        <a class="navbar-brand" href="#"><span> <?= $_SESSION['user']['username'] ?> </span></a>
    <?php endif; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
        <form class="form-inline my-2 my-lg-0" method="POST" action="/auth/login">
            <?php if (!isset($_SESSION['user'])) : ?>
                <input class="form-control mr-sm-2" name="login" type="text" placeholder="email/login" aria-label="login">
                <input class="form-control mr-sm-2" name="password" type="password" placeholder="password" aria-label="password">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                <a href="/auth/register" class="btn btn-link my-2 my-sm-0">Register</a>
            <?php else : ?>
                <a href="/auth/logout" class="btn btn-danger">logout</a>
            <?php endif; ?>
        </form>
    </div>
</nav>