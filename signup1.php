<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/header.php';
$flag=false;
$f = false;
if(empty($_POST)===false) {
	$fname = ucfirst($_POST['fname']);
	$lname = ucfirst($_POST['lname']);
	$email = $_POST['registeremail'];
	$pwd = $_POST['registerpassword'];
	$rpwd = $_POST['repassword'];
	if(user_exists($email)===true)
	{
		$errors[]= "Already existing user.";
	}
	else {	
		if(!(ctype_alpha($fname))&& !(ctype_alpha($lname))) {
			$errors[]="Only letters are allowed in NAME.";
			$f = true;
		}
		if(strlen($pwd)<6 || strlen($pwd)>15) {
			$errors[]="Password length out of BOUND -- range 6 to 15.";
			$f = true;
		}
		if($pwd != $rpwd) {
			$errors[]="Passwords don't match.";
			$f = true;
		} 
		if($f === false){
			if(register($fname,$lname,$email,$pwd))
				$flag=true;
		}
	}
}
?>
<span class="content-error">
	<?php
		if($flag)
			echo "<h2 style='color:black;padding:20px;'>Successfully Signed Up</h2>";
		else {
			echo "<h2 style='padding:20px;'>Unable to Sign you up ...</h2>";
			echo output_errors($errors);
		}
	?>
</span>
<?php include 'includes/footer.php' ?>