<html>
	<head>
		<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
	</head>
	
	<Body>
		<div class="wrap">
			<div class="header">
				header
				<div class="search">
					<form action="index.php?page=search" method="POST">
						<label>Search</label>
						<input type="text" id="search" name="search" />
						<button type="submit" name="submit">
							<span>Search</span>
						</button>
					</form>
				</div>
			</div>
			<div class="leftbox">
				<div class="firstcolumn">
					<ul>
						<li><a href="index.php?page=home">Home</a></li>
						<?php 
						if (isset($_SESSION['user_id'])){
							echo '<li><a href="index.php?page=vieworders">View Orders</a></li>';
							echo '<li><a href="index.php?page=logout">Logout</a></li>';
						} else {
							echo '<li><a href="index.php?page=login">Login</a></li>';
							echo '<li><a href="index.php?page=signup">Sign up</a></li>';
						}					
						?>
					</ul>
				</div>
				<div class="secondcolumn">
					<h6>Shopping Cart</h6>
				<table>
				<tbody>
				<?php
					if(isset($_SESSION['cart_products']) && count($_SESSION['cart_products'])>0) {
						$total = 0;
						echo '<form action="index.php?page=updatecart" method="POST">';
							foreach($_SESSION['cart_products'] as $cart_item) {
								$product_title = $cart_item['product_title'];
								$product_quantity = $cart_item['product_quantity'];
								$product_price = $cart_item['product_price'];
								$product_id = $cart_item['product_id'];
								$total = $total + $cart_item['product_price']*$cart_item['product_quantity'];
								
									echo '<tr>';
										echo '<td>'.$product_title.'</td>';
										echo '<td>'.$product_price.'</td>';
										echo '<td>Quantity <input type="text" size="2" maxlength="2" name="product_quantity['.$product_id.']" value="'.$product_quantity.'" /></td>';
										echo '<td><input type="checkbox" name="remove_id[]" value="'.$product_id.'" /> Remove</td>';
									echo '</tr>';
							}
							echo '<tr>';
								echo '<td colspan="4">Total: '.$total.'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td colspan="4"><input type="submit" name="Update" value="Update"/><a href="index.php?page=checkout" class="button">Checkout</a></td>';
							echo '</tr>';
						echo '</form>';
					}
				?>
				</tbody>
				</table>
				</div>
			</div>