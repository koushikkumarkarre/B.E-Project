<?php
include 'core/init.php';
protect_page();
include 'includes/header.php';
?>
<div class="container">
	<h3>Upload Image</h3>
	<form action="imgdecrypt.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload" style="margin-bottom:20px;" required><br/>
	<h3>Select Algorithm: </h3><br>
	<input type="radio" name="algo" value="aes"> AES<br>
	<input type="radio" name="algo" value="3des"> Triple DES<br>
	<input type="radio" name="algo" value="blowfish"> Blowfish<br>
	<h3>Password:</h3><br>
	<input type="password" name="pwd"><br>
	<Button type="submit" name='submitImage' value='Login' style="font-size:15px;">Submit</button><br/>
	</form>
</div>
<?php include 'includes/footer.php' ?>