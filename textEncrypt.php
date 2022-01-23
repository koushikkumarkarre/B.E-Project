<?php
	include 'core/init.php';
	protect_page();
	include 'includes/header.php';
?>


<div class="container">	
	<form method="POST" action="">
		<h3>Select Algorithm: </h3><br>
		<input type="radio" name="algo" value="aes" required> AES<br>
		<input type="radio" name="algo" value="3des"> Triple DES<br>
		<input type="radio" name="algo" value="blowfish"> Blowfish<br>
		<h3>Password:</h3><br>
		<input type="password" name="pwd" required><br>
		<h3>Enter Text:</h3><br>
		<textarea rows="15" cols="100" style="margin-left:10px;" name="msg" required></textarea><br/>
		<Button type="submit" name='submitAlgo' value='Submit' style="font-size:15px;">Submit</button><br/>
	</form>
	<br><br><br>
	<?php
		if(isset($_POST['submitAlgo'])){
			$selected_val = $_POST['algo'];
			$msg = $_POST['msg'];
			$pwd = $_POST['pwd'];
			if($selected_val == 'aes'){
				$output = aes_encrypt($msg,$pwd);
			}
			else if($selected_val == '3des'){
				$output = tripleDES_encrypt($msg,$pwd);
			}
			else if($selected_val == 'blowfish'){
				$output = blowfish_encrypt($msg,$pwd);
			}
	?>
	<h3>Output Response</h3><br>
	<textarea rows="15" cols="100" style="margin-left:10px;"><?php echo $output; ?></textarea><br/>
	<?php }?>
</div>


<?php include 'includes/footer.php'; ?>