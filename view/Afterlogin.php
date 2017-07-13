<?php include ('header.php')?>
	<div class="rightbox">
		<?php echo $result; ?>
		<form action="index.php?page=updateprofile" method="POST">
				<p>
					<label>Email</label>
					<?php echo '<input type="text" value='.$user_email.' name="email" />'; ?>
				</p>
			<input type="submit" name="Update" value="Update"/>
		</form>
		<form action="index.php?page=logout" method="POST">
			<input type="submit" name="Logout" value="Logout"/>
		</form>
	</div>
<?php include ('footer.php')?>