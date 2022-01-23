<?php 

function logged_in_redirect() {
	if(logged_in() === true){
		header('Location:template.php');
		exit();
	}
}

function logged_in(){
	return (isset($_SESSION['user_id'])) ?true :false ;
}

function user_exists($email)
{
	$query=mysql_query("SELECT COUNT(`email_id`) FROM `user` WHERE `email_id`='$email'");
	return (mysql_result($query,0)==1)?true:false;
}

function login($email,$password){
	$user_id=user_id_from_user($email);
	$pass= md5($password);
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `user` WHERE `email_id`='$email' AND `password`='$pass'"),0)==1) ? $user_id : false;
}

function user_id_from_user($email){
	return mysql_result(mysql_query("SELECT `user_id` FROM `user` where `email_id`='$email'"),0);
}

function getName($login) {
	return mysql_result(mysql_query("SELECT `fname` FROM `user` WHERE `user_id`='$login'"),0); 
}

function output_errors($errors){
	$output=array();
	foreach($errors as $error) {
		$output[]="<li>".$error."</li>";
	}
	return '<ul>'.implode('',$output).'</ul>';
}

function register($fname,$lname,$email,$pwd) {
	$pass = md5($pwd);
	$query=mysql_query("INSERT INTO `user`(`fname`, `lname`, `email_id`, `password`) VALUES ('$fname','$lname','$email','$pass')");
	return ($query === true) ? true : false;
}

function protect_page() {
	if(logged_in() === false){
		header('Location:protected.php');
		exit();
	}
}

function hide($imageaddr,$msg) {
$image = imagecreatefrompng($imageaddr);
$text = $msg;
$x = imagesx($image);
$y = imagesy($image);
$state =  "hide";
$char_index = 0;
$char_val = 0;
$pix_ele_index = 0;
$zeros = 0;
$storage = (($x*$y*3)/8) - 1;
if($storage < strlen($text)){
	echo "Insufficient Size text can't be hidden in the image.";
	unlink($imageaddr);
	return false;
}
for($i = 0;$i<$y;$i++){
	for($j = 0;$j<$x;$j++){
		$rgb=imagecolorat($image,$j,$i);		
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		$r_bin = sprintf("%08b",$r);
		$g_bin = sprintf("%08b",$g);
		$b_bin = sprintf("%08b",$b);
		/*$r_bin[7]=0;
		$g_bin[7]=0;
		$b_bin[7]=0;*/
		for($k = 0;$k<3;$k++){
			if($pix_ele_index%8==0){
				if($state=="zero" && $zeros == 8){
					if(($pix_ele_index-1)%3<2){
						$color = imagecolorallocate($image,bindec($r_bin),bindec($g_bin),bindec($b_bin));
						imagesetpixel($image,$j,$i,$color);
					}
					break 3;
				}
				if($char_index>=strlen($text)){
					$state = "zero";
				} 
				else {
					$char_val = ord($text[$char_index++]);
				}
			}
			switch($pix_ele_index%3){
				case 0:{
					if($state=="hide"){
						$ch_temp=$char_val%2;
						$char_val/=2;
						if(abs($r_bin[5]-$r_bin[6])!=$ch_temp){
							if($r_bin[5]==1)
								$r_bin[5]=0;
							else
								$r_bin[5]=1;
						}
					}
					else{
						$ch_temp=0;
						if(abs($r_bin[5]-$r_bin[6])!=$ch_temp){
							if($r_bin[5]==1)
								$r_bin[5]=0;
							else
								$r_bin[5]=1;
						}
					} 
				}break;
				case 1:{
					if($state=="hide"){
						$ch_temp=$char_val%2;
						$char_val/=2;
						if(abs($g_bin[5]-$g_bin[6])!=$ch_temp){
							if($g_bin[5]==1)
								$g_bin[5]=0;
							else
								$g_bin[5]=1;
						}
					}
					else{
						$ch_temp=0;
						if(abs($g_bin[5]-$g_bin[6])!=$ch_temp){
							if($g_bin[5]==1)
								$g_bin[5]=0;
							else
								$g_bin[5]=1;
						}
					}
				}break;
				case 2:{
					if($state=="hide"){
						$ch_temp=$char_val%2;
						$char_val/=2;
						if(abs($b_bin[5]-$b_bin[6])!=$ch_temp){
							if($b_bin[5]==1)
								$b_bin[5]=0;
							else
								$b_bin[5]=1;
						}
					}
					else{
						$ch_temp=0;
						if(abs($b_bin[5]-$b_bin[6])!=$ch_temp){
							if($b_bin[5]==1)
								$b_bin[5]=0;
							else
								$b_bin[5]=1;
						}
					}
					$color = imagecolorallocate($image,bindec($r_bin),bindec($g_bin),bindec($b_bin));
					imagesetpixel($image,$j,$i,$color);
				}break;
			}
			$pix_ele_index++;
			if($state=="zero"){
				$zeros++;
			}
		}
	}	
}
imagepng($image,$imageaddr);
imagedestroy($image);
$imageFileType = pathinfo($imageaddr,PATHINFO_EXTENSION);
header('Content-Description: File Transfer');
header('Content-Type: application/'.$imageFileType);
header('Content-Disposition: attachment; filename='.basename($imageaddr));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: public');
header('Pragma: public');
header('Content-Length: ' . filesize($imageaddr));
ob_clean();
flush();
readfile($imageaddr);
unlink($imageaddr);
echo "Successfully Hidden.";
}

function extractText($imageaddr) {
	$image = imagecreatefrompng($imageaddr);
	$x = imagesx($image);
	$y = imagesy($image);
	$color_index = 0;
	$char_val = 0;
	$extract_text = "";
	for($i = 0;$i<$y;$i++){
		for($j = 0;$j<$x;$j++){
			$rgb=imagecolorat($image,$j,$i);		
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			$r_bin = sprintf("%08b",$r);
			$g_bin = sprintf("%08b",$g);
			$b_bin = sprintf("%08b",$b);
			for($k = 0;$k<3;$k++){
				switch($color_index%3){
					case 0:{
						$temp = abs($r_bin[5]-$r_bin[6]);
						$char_val = $char_val * 2 + $temp; 
					}break;
					case 1:{
						$temp = abs($g_bin[5]-$g_bin[6]);
						$char_val = $char_val * 2 + $temp; 
					}break;
					case 2:{
						$temp = abs($b_bin[5]-$b_bin[6]);
						$char_val = $char_val * 2 + $temp; 
					}break;
				}
				$color_index++;
				if($color_index%8==0){
					$char_val = bindec(strrev(sprintf("%08b",$char_val)));
					if($char_val == 0){
						//echo $extract_text;
						break 3;
					}
					$c = chr($char_val);
					$char_val = 0;
					$extract_text .= $c;
				}
			}
		}
	}
	imagedestroy($image);
	unlink($imageaddr);
	return $extract_text;
}

function aes_encrypt($msg,$pwd){
	include 'phpseclib/Crypt/AES.php';
    $aes = new Crypt_AES();
    $aes->setKey($pwd);
    $plaintext = $msg;
	$a = base64_encode($aes->encrypt($plaintext));
	return $a;
}

function tripleDES_encrypt($msg,$pwd) {
	include 'phpseclib/Crypt/TripleDES.php';
    $des = new Crypt_TripleDES();
    $des->setKey($pwd);
	$a = base64_encode($des->encrypt($msg));
	return $a;
}

function blowfish_encrypt($msg,$pwd) {
	include 'phpseclib/Crypt/Blowfish.php';	
    $blowfish = new Crypt_Blowfish();
    $blowfish->setKey($pwd);
	$a = base64_encode($blowfish->encrypt($msg));
	return $a;
}

function aes_decrypt($msg,$pwd){
	include 'phpseclib/Crypt/AES.php';
    $aes = new Crypt_AES();
    $aes->setKey($pwd);
	$a = $aes->decrypt(base64_decode($msg));
	return $a;
}

function tripleDES_decrypt($msg,$pwd) {
	include 'phpseclib/Crypt/TripleDES.php';
    $des = new Crypt_TripleDES();
    $des->setKey($pwd);
	$a = $des->decrypt(base64_decode($msg));
	return $a;
}

function blowfish_decrypt($msg,$pwd) {
	include 'phpseclib/Crypt/Blowfish.php';	
    $blowfish = new Crypt_Blowfish();
    $blowfish->setKey($pwd);
	$a = $blowfish->decrypt(base64_decode($msg));
	return $a;
}
?>