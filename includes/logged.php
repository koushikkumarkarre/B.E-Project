<?php
if(logged_in()) {
	echo "<b>Hello, ".$_SESSION['fname'];
	
?>
</b><br/>
<b><a style="color:black;text-decoration:none;" href="logout.php" >Logout</a></b>
<?php
} 
?>
