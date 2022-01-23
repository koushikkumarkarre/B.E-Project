<?php 
function get_category() {
	$query = mysql_query("SELECT * FROM `category`");
	while ( $row = mysql_fetch_array($query) ) {
		$cat_id = $row['cat_id'];
		echo "<a href='display.php?cat=$cat_id'>".$row['cat_name']."</a>";
	}
}
function catIsThere($name) {
	$name = strtoupper($name);
	return (mysql_result(mysql_query("SELECT COUNT(`cat_name`) FROM `category` WHERE `cat_name`='$name'"),0)==1) ? true : false;
}
function insertCat($cat_name) {
	$cat_name=strtoupper($cat_name);
	return (mysql_query("INSERT INTO `category`(`cat_name`) VALUES ('$cat_name')"));
}
function deleteCat($cat_name) {
	$cat_name=strtoupper($cat_name);
	return (mysql_query("DELETE FROM `category` WHERE `cat_name`='$cat_name'"));
}
function insertProd($POST,$product_image){
	$product_image=$product_image;
	$product_name = ucwords($POST['prod-name']);
	$product_cat = $POST['prod-cat'];
	$product_price = $POST['prod-price'];
	$product_desc = ucwords($POST['prod-desc']);
	$product_stock = $POST['prod-stock'];
	$insert = "INSERT INTO `products`(`prod_name`, `prod_cat`, `price`, `description`, `image`, `stock`) VALUES ('$product_name','$product_cat','$product_price','$product_desc','$product_image','$product_stock')";
	$query = mysql_query($insert) or die(mysql_error());
	return $query;
}
function getProduct() {
	if(!isset($_GET['cat']) && !isset($_GET['search'])){
	$get_prod = "SELECT * FROM `products`";
	$run_prod = mysql_query($get_prod);
	while ($row_prod = mysql_fetch_array($run_prod)) {
		$prod_id = $row_prod['prod_id'];
		$prod_name = $row_prod['prod_name'];
		$prod_cat = $row_prod['prod_cat'];
		$prod_price = $row_prod['price'];
		$prod_image = $row_prod['image'];
		echo "
		<div id='single_product'>
			<h4>".$prod_name."</h4>
			<a href='details.php?id=$prod_id'><img src='core/uploads/$prod_image' width='180' height='180'/></a>
			<p><b>Rs. $prod_price</b></p>
			<a href='cart.php?add_cart=$prod_id' style='color:black;text-decoration:none;float:left;'><img src='core/images/cart.png' style='padding-right:7px;'/>Add To Cart</a>
		</div>
		";
	}
	}
}
function getCatProduct() {
	if(isset($_GET['cat'])){
		$cat_id = $_GET['cat'];
	$get_cat_prod = "SELECT * FROM `products` WHERE `prod_cat`='$cat_id'";
	$run_cat_prod = mysql_query($get_cat_prod);
	$count = mysql_num_rows($run_cat_prod);
	if($count === 0) {
		echo "<h3>No Products Found in this Category.</h3>";
	} else {
	while ($row_prod = mysql_fetch_array($run_cat_prod)) {
		$prod_id = $row_prod['prod_id'];
		$prod_name = $row_prod['prod_name'];
		$prod_cat = $row_prod['prod_cat'];
		$prod_price = $row_prod['price'];
		$prod_image = $row_prod['image'];
		echo "
		<div id='single_product'>
			<h4>".$prod_name."</h4>
			<a href='details.php?id=$prod_id'><img src='core/uploads/$prod_image' width='180' height='180'/></a>
			<p><b>Rs. $prod_price</b></p>
			<a href='cart.php?add_cart=$prod_id' style='color:black;text-decoration:none;float:left;'><img src='core/images/cart.png' style='padding-right:7px;'/>Add To Cart</a>
		</div>
		";
	}
	}
	}
}
function getDetails($id) {
	$id=(int)$id;
	$get_prod = "SELECT * FROM `products` WHERE `prod_id`=$id";
	$run_prod = mysql_query($get_prod);
	while ($row_prod = mysql_fetch_array($run_prod)) {
		$prod_id = $row_prod['prod_id'];
		$prod_name = $row_prod['prod_name'];
		$prod_price = $row_prod['price'];
		$prod_image = $row_prod['image'];
		$prod_desc = $row_prod['description'];
		echo "
		<div id='single_product_detail'>
			<img src='core/uploads/$prod_image' style='float:left;margin-right:20px;border:1px solid black;' width='300' height='350'/>
			<h2>".$prod_name."</h2>
			<a href='cart.php?add_cart=$prod_id' style='color:black;text-decoration:none;float:right;'><img src='core/images/cart.png' style='padding-right:7px;'/>Add To Cart</a>
			<p><b>Rs. $prod_price</b></p>
			<h4><u>Description</u></h4>
			<p style='font-size:14px;'>$prod_desc</p>
		</div>
		";
	}
}
function getResult() {
	if(isset($_GET['search'])){
	$search_query = $_GET['query'];
	$get_prod = "SELECT * FROM `products` WHERE `prod_name` like '%$search_query%'";
	$run_prod = mysql_query($get_prod);
	$count = mysql_num_rows($run_prod);
	if($count === 0) {
		echo "<h2>No such Product FOUND!</h2>";
	} else {
	while ($row_prod = mysql_fetch_array($run_prod)) {
		$prod_id = $row_prod['prod_id'];
		$prod_name = $row_prod['prod_name'];
		$prod_cat = $row_prod['prod_cat'];
		$prod_price = $row_prod['price'];
		$prod_image = $row_prod['image'];
		echo "
		<div id='single_product'>
			<h4>".$prod_name."</h4>
			<a href='details.php?id=$prod_id'><img src='core/uploads/$prod_image' width='180' height='180'/></a>
			<p><b>Rs. $prod_price</b></p>
			<a href='cart.php?add_cart=$prod_id' style='color:black;text-decoration:none;float:left;'><img src='core/images/cart.png' style='padding-right:7px;'/>Add To Cart</a>
		</div>
		";
	}
	}
	}
}
function cart() {
	global $user_data;
	if(isset($_GET['add_cart'])) {
		$user_id = $user_data['cust_id'];
		$pro_id = $_GET['add_cart'];
		$check_pro = "SELECT * FROM `cart` WHERE `cust_id`='$user_id' AND `prod_id`=$pro_id";
		$run_check = mysql_query($check_pro);
		if(mysql_num_rows($run_check)>0) {
			echo "";
		} else {
			$insert_pro = "INSERT INTO `cart`(`prod_id`, `cust_id`) VALUES ('$pro_id','$user_id')";
			$run_pro = mysql_query($insert_pro);
			
		}
	}
}
function total_items() {
	global $user_data;
	if (isset($_GET['add_cart'])) {
		$user_id = $user_data['cust_id'];
		$get_items = "SELECT * FROM `cart` WHERE `cust_id`='$user_id'";
		$run_items = mysql_query($get_items);
		$count_items = mysql_num_rows($run_items);
	}
	else {
		$user_id = $user_data['cust_id'];
		$get_items = "SELECT * FROM `cart` WHERE `cust_id`='$user_id'";
		$run_items = mysql_query($get_items);
		$count_items = mysql_num_rows($run_items);
	}
	echo $count_items;
}
function total_price() {
	global $user_data;
	$total=0;
	$user_id = $user_data['cust_id'];
	$sel_price = "SELECT * FROM `cart` WHERE `cust_id`='$user_id'";
	$run_price = mysql_query($sel_price);
	while($p_price=mysql_fetch_array($run_price)){
		$pro_id=$p_price['prod_id'];
		$pro_qty=$p_price['qty'];
		$pro_price="SELECT * FROM `products` WHERE `prod_id`='$pro_id'";
		$run_pro_price=mysql_query($pro_price);
		$price=mysql_fetch_array($run_pro_price);
		$product_price=$price['price'];
		$values=$product_price*$pro_qty;
		$total+=$values;
	}
	return $total;
}
function cartEmpty($uid) {
	$uid=(int)$uid;
	$query=mysql_query("SELECT * FROM `cart` WHERE `cust_id`='$uid'");
	$run=mysql_num_rows($query);
	return ($run == 0) ? true : false;
}
function transferCart($uid,$addr) {
	$uid=(int)$uid;
	$sel_cart=mysql_query("SELECT * FROM `cart` WHERE `cust_id`='$uid'");
	$t_val = total_price();
	$qry_pay = mysql_query("INSERT INTO `payment`(`cust_id`, `amount`,`ship_addr`) VALUES ('$uid','$t_val','$addr')");
	$pay_run = mysql_query("SELECT * FROM `payment` WHERE `cust_id`='$uid' AND `timestamp`=(SELECT max(`timestamp`) FROM `payment` WHERE `cust_id`='$uid')");
	$payment_run = mysql_fetch_assoc($pay_run);
	$oid = $payment_run['order_id'];
	while($run_cart=mysql_fetch_assoc($sel_cart)) {
		$pid = $run_cart['prod_id'];
		$qty = $run_cart['qty'];
		$query = mysql_query("INSERT INTO `order`(`prod_id`, `cust_id`, `qty`, `order_id`) VALUES ('$pid','$uid','$qty','$oid')");
	}
	$del_query = mysql_query("DELETE FROM `cart` WHERE `cust_id`='$uid'");
	return true;
}
?>