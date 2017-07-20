<?php
	include_once("model/Model.php");
	
	class Controller {
		public $model;
			
		public function __construct() {
			$this->model = new Model();
			$sort = ''; 
		}
			
		public function invoke() {
			if (! isset($_GET['page'])) {
				if(isset($_GET['email']) && isset($_GET['hash'])) {
					$result = $this->model->getVerifyUser();
					include ('view/login.php');
				} else if(isset($_GET['sort'])) {
					if(isset($_GET['sort'])) {
						$sort = $_GET['sort'];
					}
					$lastSpace = strpos($sort, " ");
					$order = substr($sort, $lastSpace+1);
					$sort = substr($sort, 0, $lastSpace);
					$products = $this->model->getArticles($sort, $order);
					$totalItems = $this->model->getTotalItems();
					$pageNumbers = $totalItems['row']/10;
					$pageNumbers = ceil($pageNumbers);
					include ('view/home.php');
				} else {
					Header ('Location: index.php?page=home');
				}
			} else {	
				$page = $_GET['page'];
				switch ($page) {
					case 'home';
						$sort = 'product_id';
						$order = 'ASC';
						$products = $this->model->getArticles($sort, $order);
						$totalItems = $this->model->getTotalItems();
						$pageNumbers = $totalItems['row']/10;
						$pageNumbers = ceil($pageNumbers);
						include ('view/home.php');
						break;
					
					case 'login';
						$result = $this->model->getLogin();
						if ($result == 'login') {
							$user_email = $this->model->getUserEmail();
							include ('view/Afterlogin.php');
						} else {
							include ('view/login.php');
						}
						break;
						
					case 'signup';
						$result = $this->model->getRegister();
						if($result == 'register') {
							Header('Location: index.php?page=login');
						} else {
							include ('view/signup.php');
						}
						break;
						
					case 'logout';
						$result = $this->model->getLogout();
						if($result == 'logout') {
							Header('Location: index.php?page=login');
						} 
						break;
		
					case 'updateprofile';
						$result = $this->model->getUpdateProfile();
						if($result == 'updated') {
							Header('Location: index.php?page=login');
						} 
						break;
						
					case 'vieworders';
						$orders = $this->model->getAllOrders();
						include('view/vieworders.php');
						break;
						
					case 'updatecart';
						if(isset($_POST['type']) && $_POST['type']=='add' && $_POST['product_quantity'] > 0) {
							$result = $this->model->getNewCartProduct();
						}
						if(isset($_POST['product_quantity']) || isset($_POST['remove_id'])) {
							$result = $this->model->getUpdateCartProduct();
						}
						if(isset($_POST['remove_id']) && is_array($_POST['remove_id'])) {
							$result = $this->model->getRemoveCartProduct();
						}
						Header('Location: index.php?page=home');
					
					case 'checkout';
						include('view/checkout.php');
						break;
						
					case 'placeorder';
						$result = $this->model->getPlaceOrder();
						Header('Location: index.php?page=home');
						break;
					
					case 'search';
						$search =  $this->model->getSearch();
						include('view/search.php');
						break;
				}
			}
		}
	}
?>