<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/header.php';
?>
<div class="login">
<?php
if(empty($_POST)=== false)
{
	$email=$_POST['loginemail'];
	$password=$_POST['loginpassword'];
	if(user_exists($email)===false)
	{
		$errors[]="We can't find you. Have you registered ?";
	}
	else {
		$login = login ($email,$password);
		if($login === false) {
			$errors[]="Your email and password don't match";
		} else {
			$fname = getName($login);
			$_SESSION['fname'] = $fname;
			$_SESSION['user_id'] = $login;
			header('Location:template.php');
			exit();
		}
	}
	output_errors($errors);
}
?>
<h2>Login</h2>
<span class="content-error">
	<?php
		echo output_errors($errors);
	?>
</span>
<form action="login.php" method='POST'>
	E-Mail : <br/>
	<input type="text" name="loginemail"><br>
	Password :<br/>
	<input type="password" name="loginpassword"><br>
	<Button type="submit" name='btnLogin' value='Login'>LOGIN</button><br/>
</form>
<h4>Haven't Registered? Register <a href="register.php">HERE</a></h4>
</div>
<?php include 'includes/footer.php' ?>