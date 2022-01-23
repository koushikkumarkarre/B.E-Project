<?php 
function user_data($user_id) {
	$data = array();
	$user_id=(int)$user_id;
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	if($func_num_args > 1) {
		unset($func_get_args[0]);
		$fields = '`'.implode('`, `',$func_get_args).'`';
		$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `customer` where `cust_id`='$user_id'"));
		return $data;
	}
}
function register($fname,$lname,$email,$pwd,$type,$dob,$cntct) {
	$query=mysql_query("INSERT INTO `customer`(`email`, `first_name`, `last_name`, `dob`, `type`, `mobile`, `password`) VALUES ('$email','$fname','$lname','$dob','$type','$cntct','$pwd')");
	return ($query === true) ? true : false;
}
function user_exists($email)
{
	$query=mysql_query("SELECT COUNT(`cust_id`) FROM `customer` WHERE `email`='$email'");
	return (mysql_result($query,0)==1)?true:false;
}
function cust_id_from_customer($email){
	return mysql_result(mysql_query("SELECT `cust_id` FROM `customer` where `email`='$email'"),0);
}
function login($email,$password){
	$cust_id=cust_id_from_customer($email);
	return (mysql_result(mysql_query("SELECT COUNT(`cust_id`) FROM `customer` WHERE `email`='$email' AND `password`='$password'"),0)==1) ? $cust_id : false;
}
function getName($login) {
	return mysql_result(mysql_query("SELECT `first_name` FROM `customer` WHERE `cust_id`='$login'"),0); 
}
function output_errors($errors){
	$output=array();
	foreach($errors as $error) {
		$output[]="<li>".$error."</li>";
	}
	return '<ul>'.implode('',$output).'</ul>';
}
function logged_in(){
	return (isset($_SESSION['cust_id'])) ?true :false ;
}
function protect_page() {
	if(logged_in() === false){
		header('Location:protected.php');
		exit();
	}
}
function admin_protect() {
	global $user_data;
	if(has_access($user_data['cust_id'],3) === false) {
		header('Location:home1.php');
		exit();
	}
}
function block_admin() {
	global $user_data;
	if(!(has_access($user_data['cust_id'],1) || has_access($user_data['cust_id'],2))) {
		header('Location:home1.php');
		exit();
	}
}
function block_user() {
	global $user_data;
	if(!(has_access($user_data['cust_id'],3) || has_access($user_data['cust_id'],4))) {
		header('Location:home1.php');
		exit();
	}
}
function has_access($user_id,$type) {
	$user_id=(int)$user_id;
	$type=(int)$type;
	return (mysql_result(mysql_query("SELECT COUNT(`cust_id`) FROM `customer` WHERE `cust_id`=$user_id AND `type`=$type"),0) == 1) ? true : false;
}
function logged_in_redirect() {
	if(logged_in() === true){
		header('Location:home1.php');
		exit();
	}
}
function update_user($update_data){
	$update = array();
	foreach($update_data as $fields=>$data) {
		$update[] = '`'.$fields.'`=\''.$data.'\'';
	}
	mysql_query("UPDATE `customer` SET".implode(', ',$update)."WHERE `cust_id`=".$_SESSION['cust_id']);
}
function change_password($user_id,$password) {
	$user_id=(int)$user_id;
	mysql_query("UPDATE `customer` SET `password` = '$password' WHERE `cust_id`='$user_id'");
}
function registerComment($name,$email,$comment,$cntct) {
	$query=mysql_query("INSERT INTO `comment`(`name`, `mobile`, `email`, `comment`) VALUES ('$name','$cntct','$email','$comment')");
	return ($query === true) ? true : false;
}
?>