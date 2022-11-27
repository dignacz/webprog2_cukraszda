<?php include('server.php') ?>
<div class="container">
	<div class="row">
		<h1>Regisztráció</h1>
		<h6 class="information-text">Csatlakozz a Sütiforradalomhoz!</h6>
		<div class="form-group">
        <form method="post" action="register.php">
  	    <?php include('errors.php'); ?>
			<p><label for="username">Felhasználónév</label></p>
            <input type="text" name="username" id="username" value="<?php echo $username; ?>">
			<p><label for="lastname">Vezetéknév</label></p>
            <input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>">
			<p><label for="firstname">Keresztnév</label></p>
            <input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
			<p><label for="email">Email</label></p>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>">
			<p><label for="password_1">Jelszó</label></p>
            <input type="password" name="password_1" id="password_1">
			<p><label for="password_2">Jelszó Újra</label></p>
            <input type="password" name="password_2" id="password_2">
			<button type="submit" class="btn" name="reg_user">Regisztráció</button>
		</div>
		<div class="footer">
			<h5>Már regisztráltál? <a href="index.php?page=login">Lépj be!</a></h5>
		</div>
	</div>
</div>
	