<?php include ('header.php')?>
<div class="rightbox">
	<?php
		if (isset($_SESSION['user_id'])) {
			echo '<table>';
				foreach($_SESSION['cart_products'] as $cart_item) {
					echo '<tr>';
						echo '<td>'.$cart_item['product_id'].'</td>';
						echo '<td>'.$cart_item['product_title'].'</td>';
						echo '<td>'.$cart_item['product_quantity'].'</td>';
						echo '<td>'.$cart_item['product_price'].'</td>';
						echo '<td>'.$cart_item['product_id'].'</td>';
					echo '</tr>';
				}
			echo '</table>';
			echo '<form action="index.php?page=placeorder" method="POST">';
				echo '<input type="submit" name="checkout" value="Place Order"/>';
			echo '</form>';
		} else {
			echo 'Please login!';
		}
	?>
</div>
<?php include ('footer.php')?>