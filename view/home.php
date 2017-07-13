<?php include ('header.php')?>
<div class="rightbox">
	<p>
		<form action="index.php?page=sort" method="POST">
			Sort items
			<select id="sort" name="sort">
				<option value="product_id ASC" <?php if(isset($_POST['sort']) && $_POST['sort']== 'product_id ASC') { echo 'selected="selected"';  }?> >ID ASC</option>
				<option value="product_title ASC" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'product_title ASC') { echo 'selected="selected"';  }?> >Title ASC</option>
				<option value="product_price ASC" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'product_price ASC') { echo 'selected="selected"';  }?> >Price ASC</option>
				<option value="product_id DESC" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'product_id DESC') { echo 'selected="selected"';  }?> >ID DESC</option>
				<option value="product_title DESC" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'product_title DESC') { echo 'selected="selected"';  }?> >Title DESC</option>
				<option value="product_price DESC" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'product_price DESC') { echo 'selected="selected"';  }?> >Price DESC</option>
			</select>
			<button type="submit" name="submit">
				<span>Sort</span>
			</button>
		</form>
	</p>
	<?php
		/*echo '<table>';
		while($row = mysqli_fetch_assoc($result)) {
			echo '<tr>';
				echo '<td>'.$row['product_id'].'</td>';
				echo '<td>'.$row['product_name'].'</td>';
				echo '<td>'.$row['product_desc'].'</td>';
				echo '<td>'.$row['product_price'].'</td>';
			echo '</tr>';
		}
		echo '</table>';*/
		echo '<table>';
			echo '<tbody>';
				if(empty($products)) {
						echo 'No articles found!';
					} else {
						foreach($products as $key => $value) {
							echo '<tr>';
								echo '<form action="index.php?page=updatecart" method="POST">';
									echo '<td>'.$value['product_id'].'</td>';
									echo '<td><img src="'.$value['product_image'].'" /></td>';
									echo '<td>'.$value['product_title'].'</td>';
									echo '<td>'.$value['product_desc'].'</td>';
									echo '<td>'.$value['product_price'].'</td>';
									echo '<td><input type="text" size="2" maxlength="2" name="product_quantity" value="1" /></td>';
									echo '<td><input type="hidden" name="product_id" value="'.$value['product_id'].'" /></td>';
									echo '<td><input type="hidden" name="type" value="add" /></td>';
									echo '<td><input type="submit" name="submitButton" value="Add to cart"/></td>';
								echo '</form>';
								/*foreach($value as $key2 => $value2) {
									if($key2 == 'product_image') {
										echo '<td><img src="'.$value2.'" /></td>';
									} else {
										echo '<td>'.$value2.'</td>';
									}
								}*/
							echo '</tr>';
						}
					}
			echo '</tbody>';
		echo '</table>';
	?>
</div>
<?php include ('footer.php')?>