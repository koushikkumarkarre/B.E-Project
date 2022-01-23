<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/header.php';
?>
<div class="register">
<h2>Register</h2>
<form action="signup1.php" method='POST'>
	First Name :<br/>
	<input type="text" name="fname" required><br>
	Last Name :<br/>
	<input type="text" name="lname" required><br>
	E-Mail :<br/>
	<input type="email" name="registeremail" required><br>
	Password :<br/>
	<input type="password" name="registerpassword" required><br>
	Retype Password :<br/>
	<input type="password" name="repassword" required><br>
	<Button type="submit" value='Register' name='btnRegister'>REGISTER</button><br/>
</form>
<h4>Already have an account. Login <a href="login.php">HERE</a></h4>
</div>
<?php include 'includes/footer.php' ?>