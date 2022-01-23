<?php
include 'core/init.php';
protect_page();
include 'includes/header.php';
?>
<div class="container">
	<h2 style="border-bottom:2px solid black;text-align:center;padding-bottom:10px;">About It</h2>
	<p style="text-align: justify;text-justify: inter-word;padding:0 30px 0 30px;">This is a Security based project that deals with the issue of transferring data over unsecure networks. It gives the control to the user who's data is on the risk and let's him select the algorithm and iterate it how many times he wants. While also implementing a new technique of Steganography.</p>
	<p style="text-align: justify;text-justify: inter-word;padding:0 30px 0 30px;">Algorithm currently being supported are - <b>AES, Triple DES & Blowfish</b>.</p><br/>
	<h2 style="border-bottom:2px solid black;text-align:center;padding-bottom:10px;">Advanced Encryption Standard (AES)</h2>
	<p style="text-align: justify;text-justify: inter-word;padding:0 30px 0 30px;">The Advanced Encryption Standard (AES), also known by its original name Rijndael is a specification for the encryption of electronic data established by the U.S. National Institute of Standards and Technology (NIST). AES is based on a design principle known as a substitution-permutation network, a combination of both substitution and permutation, and is fast in both software and hardware. AES is a variant of Rijndael which has a fixed block size of 128 bits, and a key size of 128, 192, or 256 bits.</p><br/>
	<h2 style="border-bottom:2px solid black;text-align:center;padding-bottom:10px;">Triple DES (3DES)</h2>
	<p style="text-align: justify;text-justify: inter-word;padding:0 30px 0 30px;">Triple DES (3DES), officially the Triple Data Encryption Algorithm (TDEA or Triple DEA), is a symmetric-key block cipher, which applies the Data Encryption Standard (DES) cipher algorithm three times to each data block. The original DES cipher's key size of 56 bits was generally sufficient when that algorithm was designed, but the availability of increasing computational power made brute-force attacks feasible. Triple DES provides a relatively simple method of increasing the key size of DES to protect against such attacks, without the need to design a completely new block cipher algorithm. </p><br/>
	<h2 style="border-bottom:2px solid black;text-align:center;padding-bottom:10px;">Blowfish</h2>
	<p style="text-align: justify;text-justify: inter-word;padding:0 30px 0 30px;">Blowfish is a symmetric-key block cipher. Blowfish provides a good encryption rate in software and no effective cryptanalysis of it has been found to date. However, the Advanced Encryption Standard (AES) now receives more attention. Blowfish is unpatented, and will remain so in all countries. The algorithm is hereby placed in the public domain, and can be freely used by anyone. Blowfish has a 64-bit block size and a variable key length from 32 bits up to 448 bits.</p><br/>
</div>
<?php include 'includes/footer.php' ?>