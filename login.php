<?php include('server.php') ?>
<div class="container">
	<div class="row">
		<h1>Bejelentkezés</h1>
        <form method="post" action="login.php">
  	    <?php include('errors.php'); ?>
		<div class="form-group">
			<input type="text" name="username" id="username">
			<p><label for="username">Felhasználónév</label></p>
			<input type="password" name="password" id="password">
			<p><label for="password">Jelszó</label></p>
			<button type="submit" class="btn" name="login_user">Belépés</button>
		</div>
		<div class="footer">
			<h5>Még nem regisztráltál? <a href="index.php?page=register">Itt megteheted!</a></h5>
		</div>
	</div>
</div>

    