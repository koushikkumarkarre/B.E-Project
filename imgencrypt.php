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
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Allow certain file formats
if($imageFileType != "png" && $imageFileType != "bmp" ) {
    echo "Sorry, only PNG & BMP files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$output = $_POST['message'];
        if(isset($_POST['algo']) && isset($_POST['pwd'])){
			$selected_val = $_POST['algo'];
			$msg = $_POST['message'];
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
		}
		hide($target_file,$output);
		}
     else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
</div>
<?php include 'includes/footer.php' ?>