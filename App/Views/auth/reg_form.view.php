<!DOCTYPE html>
<html lang="en">

<head>
	<?php include __DIR__ . './../components/meta.view.php' ?>
	<title>Register form</title>
</head>

<body>
	<div class="container">
		<div class="col-md-12">
			<h2 class="text-center">Регистрация</h2>
			<?php if (count($errors)) : ?>
				<div class="col-md-12 alert alert-danger">
					<ul>
						<?php foreach ($errors as $field => $errors) : ?>
							<?php foreach ($errors as $error) : ?>
								<li><?php echo $error ?></li>
							<?php endforeach ?>
						<?php endforeach ?>
					</ul>
				</div>
			<?php endif ?>
			<div class="well col-md-12">
				<form action="/auth/register" method="POST">
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="email">
					</div>
					<div class="form-group">
						<input type="text" name="username" class="form-control" placeholder="username">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="password">
					</div>
					<input type="submit" value="Зарегистрироваться" class="btn btn-success">
				</form>
			</div>
		</div>
	</div>
</body>

</html>