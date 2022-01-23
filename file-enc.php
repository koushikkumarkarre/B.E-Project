<?php
include 'core/init.php';
protect_page();
include 'includes/header.php';
?>
<div style="margin:20px;">
<?php
$target_dir = "core/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = filesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File input confirmed - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not proper.";
        $uploadOk = 0;
    }
}
// Allow certain file formats
if($fileType != "txt") {
    echo "Sorry, only TXT files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$fileContent = file_get_contents($target_file);
		$selected_val = $_POST['algo'];
		$pwd = $_POST['pwd'];
		if($selected_val == 'aes'){
			$output = aes_encrypt($fileContent,$pwd);
		}
		else if($selected_val == '3des'){
			$output = tripleDES_encrypt($fileContent,$pwd);
		}
		else if($selected_val == 'blowfish'){
			$output = blowfish_encrypt($fileContent,$pwd);
		}
		file_put_contents($target_file, $output);
		header('Content-Description: File Transfer');
		header('Content-Type: text/plain');
		header('Content-Disposition: attachment; filename='.basename($target_file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: public');
		header('Pragma: public');
		header('Content-Length: ' . filesize($target_file));
		ob_clean();
		flush();
		readfile($target_file);
		unlink($target_file);
	}
     else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
</div>
<?php include 'includes/footer.php' ?>