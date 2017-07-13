<?php include ('header.php')?>
<div class="rightbox">
	<?php
		echo '<table class="table">';
			echo '<thead>';
				echo '<tr>';
					echo '<td>Order ID</td>';
					echo '<td>Order date</td>';
					echo '<td>Order title</td>';
					echo '<td>Order price</td>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
				foreach($orders as $key => $value) {
					echo '<tr>';
						echo '<td>'.$value['order_id'].'</td>';
						echo '<td>'.$value['order_date'].'</td>';
						echo '<td>'.$value['product_title'].'</td>';
						echo '<td>'.$value['product_price'].'</td>';
					echo '</tr>';
				}
			echo '</tbody>';
		echo '</table>';
	?>
</div>
<?php include ('footer.php')?>