<?php
	include_once("dbconnect.php");
	
	class Model {
		
		function __construct() {
			$this->connection = new dbconnect();
			session_start();
		}
		
		public function getLogin() {
			$conn = $this->connection->connect();
			
			if(!isset($_SESSION['user_id'])) {
				if(isset($_POST['username']) && isset($_POST['password'])) {
					$username = trim(mysqli_escape_string($conn,$_POST['username']));
					$password = trim(mysqli_escape_string($conn,$_POST['password']));
				
					$stmt = mysqli_prepare($conn, "SELECT user_id, user_password FROM users WHERE user_username = ?");
					
					if($stmt) {
						mysqli_stmt_bind_param($stmt, 's', $username);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_bind_result($stmt, $userid, $userpassword);
						mysqli_stmt_fetch($stmt);
						mysqli_stmt_close($stmt);
						if (!password_verify($password, $userpassword)) {
							return 'Invalid user';
						} else {
							$_SESSION['user_id'] = $userid;
							return 'login';
						}		
					}
				}
			} else {
				return 'login';
			}
		}
		
		private function getCheckUser($username, $email) {
			$conn = $this->connection->connect();
			
			$stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE user_username = ? or user_email = ?");
					
			if($stmt) {
				mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $userid);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
			}
			return $userid;
		}
		
		public function getUserEmail() {
			$conn = $this->connection->connect();
			
			$user_id = $_SESSION['user_id'];
			$stmt = mysqli_prepare($conn, "SELECT user_email FROM users WHERE user_id = ?");
			
			if($stmt) {
				mysqli_stmt_bind_param($stmt, 'i', $user_id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $user_email);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
			}
			return $user_email;
		}
		
		private function getSendActivEmail($email, $hash) {
			$to = $email;
			$subject = 'Signup Verification';
			$message = '
			Thanks for signing up!
			Your account has been created, you can login with your credentials after you have activated your account by pressing the url below.

			Please click this link to activate your account:
			http://localhost/cart_mvc/model/verify.php?email='.$email.'&hash='.$hash.'
			
			';
			
			$headers = 'From: noreply@localhost';
			mail($to, $subject, $message, $header);
			
			return true;
		}
		
		public function getRegister() {
			$conn = $this->connection->connect();
			
			if(!isset($_SESSION['user_id'])) {
				if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
					if ($_POST['username']!= '' && $_POST['password']!='' && $_POST['email']!='') {
						$username = trim(mysqli_escape_string($conn,$_POST['username']));
						$password = trim(mysqli_escape_string($conn,$_POST['password']));
						$email = trim(mysqli_escape_string($conn,$_POST['email']));
						
						if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
							return 'Invalid email';
						} else {
							$password_hash = password_hash($password, PASSWORD_DEFAULT);
							$hash = md5(rand(0,1000));
							
							$userid = $this->getCheckUser($username, $email);
							
							if (!$userid) {
								$stmt = mysqli_prepare($conn, "INSERT INTO users (user_username, user_password, user_email, user_hash) VALUES (?, ?, ?, ?)");
								mysqli_stmt_bind_param($stmt, 'ssss', $username, $password_hash, $email, $hash);
								mysqli_stmt_execute($stmt);
								$email_sent = $this->getSendActivEmail($email, $hash);
								mysqli_stmt_close($stmt);
								return 'register';
							} else {
								return 'User is registered';
							}
						}
					} else {
						return 'Fill out the form';
					}
				}
			} else {
				return 'register';
			}
		}
		
		public function getLogout() {
			unset($_SESSION['user_id']);
			return 'logout';
		}
		
		public function getUpdateProfile() {
			$conn = $this->connection->connect();
			
			$user_email = trim(mysqli_escape_string($conn,$_POST['email']));
			$user_id = $_SESSION['user_id'];
			
			$stmt = mysqli_prepare($conn, "UPDATE users SET user_email = ? WHERE user_id = ? ");
			
			if($stmt) {
				mysqli_stmt_bind_param($stmt, 'si', $user_email, $user_id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
				return 'updated';
			}
		}
		
		public function getVerifyUser() {
			$conn = $this->connection->connect();
			if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])) {
				$email = mysql_escape_string($_GET['email']);
				$hash = mysql_escape_string($_GET['hash']);
				
				$stmt = mysqli_prepare($conn, "SELECT user_email, user_hash, user_active FROM users WHERE user_email = ? AND user_hash = ?");
					
				if($stmt) {
					mysqli_stmt_bind_param($stmt, 'ss', $email, $hash);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $user_email, $user_hash, $user_active);
					mysqli_stmt_fetch($stmt);
					mysqli_stmt_close($stmt);
					if($user_hash) {
						echo $user_hash;
						$stmt = mysqli_prepare($conn, "UPDATE users SET user_active = 1 WHERE user_email = ? AND user_hash = ? ");
						if($stmt) {
							mysqli_stmt_bind_param($stmt, 'ss', $email, $hash);
							mysqli_stmt_execute($stmt);
							mysqli_stmt_close($stmt);
							return 'activated';
						}
					} else {
						return 'invalid';
					}
				}
			} else {
				return 'invalid';
			}
		}
		
		public function getArticles($sort, $order) {
			$conn = $this->connection->connect();
			
			$paging = 0;
			
			if(isset($_GET['paging'])) {
				$paging = $_GET['paging'];
				$paging = $paging * 10;
				$paging = $paging - 10;
			}

			$stmt = mysqli_prepare($conn, "SELECT product_id, product_image, product_title, product_desc, product_price FROM products ORDER BY ".$sort." ".$order." LIMIT ".$paging.", 10");
			
			if($stmt) {
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
				mysqli_stmt_close($stmt);
				return $products;
			} else {
				return array();
			}
		}
		
		public function getAllOrders() {
			$conn = $this->connection->connect();
			
			if(isset($_SESSION['user_id'])) {
				$user_id = $_SESSION['user_id'];
			
				$stmt = mysqli_prepare($conn, "SELECT product_title, product_price, order_id, order_date FROM orders INNER JOIN products ON order_product_id = product_id and order_user_id = ?");
				
				if($stmt) {
					mysqli_stmt_bind_param($stmt, 'i', $user_id);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
					mysqli_stmt_close($stmt);
					return $orders;
				}
			} else {
				return array();
			}
		}
		
		public function getNewCartProduct() {
			$conn = $this->connection->connect();
			
			if(isset($_POST['type']) && $_POST['type']=='add' && $_POST['product_quantity'] > 0) {
				foreach($_POST as $key => $value) {
					$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
				}
				unset($new_product['type']);
				unset($new_product['submitButton']);
				
				$stmt = mysqli_prepare($conn, "SELECT product_title, product_price FROM products WHERE product_id = ?");
				
				if($stmt) {
					mysqli_stmt_bind_param($stmt, 'i', $new_product["product_id"]);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $product_title, $product_price);
					mysqli_stmt_fetch($stmt);
					mysqli_stmt_close($stmt);					
				}
				$new_product['product_title'] = $product_title;
				$new_product['product_price'] = $product_price;
				if(isset($_SESSION['cart_products'][$new_product['product_id']])) {
					$_SESSION['cart_products'][$new_product['product_id']]['product_quantity'] += $new_product['product_quantity'];
				} else {
					$_SESSION['cart_products'][$new_product['product_id']] = $new_product;
				}
			}
		}
		
		public function getUpdateCartProduct() {
			if(isset($_POST['product_quantity']) || isset($_POST['remove_id'])) {
				if(isset($_POST['product_quantity']) && is_array($_POST['product_quantity'])) {
					foreach($_POST['product_quantity'] as $key => $value) {
						if(is_numeric($value)) {
							$_SESSION['cart_products'][$key]['product_quantity']= $value;
						}
					}
				}
			}
		}
		
		public function getRemoveCartProduct() {
			if(isset($_POST['remove_id']) && is_array($_POST['remove_id'])) {
				foreach($_POST['remove_id'] as $key) {
					unset($_SESSION['cart_products'][$key]);
				}
			}
		}
		
		public function getPlaceOrder() {
			$conn = $this->connection->connect();
			foreach($_SESSION['cart_products'] as $cart_item) {
				$product_id = $cart_item['product_id'];
				$user_id = $_SESSION['user_id'];
				$date = date('Y-m-d H:i:s');
				$stmt = mysqli_prepare($conn, "INSERT INTO orders (order_date, order_product_id, order_user_id) VALUES (?, ?, ?)");
				mysqli_stmt_bind_param($stmt, 'sss', $date, $product_id, $user_id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
			}
			unset($_SESSION['cart_products']);
		}
		
		public function getSearch() {
			$conn = $this->connection->connect();
			
			if ($_POST['search']!= '') {
				$search = trim(mysqli_escape_string($conn,$_POST['search']));
				$stmt = mysqli_prepare($conn, "SELECT product_id, product_image, product_title, product_desc, product_price FROM products WHERE product_title LIKE ? OR product_desc LIKE ? ORDER BY product_id ASC");	
				$search = '%'.$search.'%';
				if($stmt) {
					mysqli_stmt_bind_param($stmt, 'ss', $search, $search);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$search = mysqli_fetch_all($result, MYSQLI_ASSOC);
					mysqli_stmt_close($stmt);
					return $search;
				} else {
					return array();
				}
			} else {
				return array();
			}
		}
		
		public function getTotalItems() {
			$conn = $this->connection->connect();
			$stmt = mysqli_prepare($conn, "SELECT COUNT(product_id) as row FROM products");	
			if($stmt) {
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				$total = mysqli_fetch_assoc($result);
				mysqli_stmt_close($stmt);
			}
			return $total;
		}
	}
?>