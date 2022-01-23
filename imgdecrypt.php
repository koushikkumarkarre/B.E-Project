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
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		$output = extractText($target_file);
		if(isset($_POST['algo']) && isset($_POST['pwd'])) {
			$selected_val = $_POST['algo'];
			$msg = $output;
			$pwd = $_POST['pwd'];
			if($selected_val == 'aes'){
				$output = aes_decrypt($msg,$pwd);
			}
			else if($selected_val == '3des'){
				$output = tripleDES_decrypt($msg,$pwd);
			}
			else if($selected_val == 'blowfish'){
				$output = blowfish_decrypt($msg,$pwd);
			}
		}
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
<h3 style="margin-bottom:0;">Message:</h3><br/>
<textarea rows="15" cols="100" style="margin-left:10px;" name="message" id="message" required><?php echo $output; ?></textarea><br/>
</div>
<?php include 'includes/footer.php' ?>