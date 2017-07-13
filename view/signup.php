<?php include ('header.php')?>
<div class="rightbox">
	<?php echo '<p>'.$result.'</p>'; ?>
	<form action="" method="POST" class="styleform">
		<p>
			<label for="login">Username: </label>
			<input type="text" name="username" />
		</p>
		<p>
			<label for="password">Password: </label>
			<input type="password" name="password" />
		</p>
		<p>
			<label for="email">E-Mail: </label>
			<input type="text" name="email" />
		</p>
		<p>
			<button type="submit" name="submit">
				<span>Sign up</span>
			</button>
			<button type="reset">
				<span>Cancel</span>
			</button>
		</p>
	</form>
</div>
<?php include ('footer.php')?>