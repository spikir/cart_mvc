<?php include ('header.php')?>
<div class="rightbox">
	<?php
		echo '<table>';
			echo '<tbody>';
				if(empty($search)) {
					echo 'No articles found!';
				} else {
					foreach($search as $key => $value) {
						echo '<tr>';
							echo '<form action="index.php?page=updatecart" method="POST">';
								echo '<td>'.$value['product_id'].'</td>';
								echo '<td><img src="'.$value['product_image'].'" width="150" height="100"/></td>';
								echo '<td>'.$value['product_title'].'</td>';
								echo '<td>'.$value['product_desc'].'</td>';
								echo '<td>'.$value['product_price'].'</td>';
								echo '<td><input type="text" size="2" maxlength="2" name="product_quantity" value="1" /></td>';
								echo '<td><input type="hidden" name="product_id" value="'.$value['product_id'].'" /></td>';
								echo '<td><input type="hidden" name="type" value="add" /></td>';
								echo '<td><input type="submit" name="submitButton" value="Add to cart"/></td>';
							echo '</form>';
						echo '</tr>';
					}
				}
			echo '</tbody>';
		echo '</table>';
		
	?>
</div>
<?php include ('footer.php')?>