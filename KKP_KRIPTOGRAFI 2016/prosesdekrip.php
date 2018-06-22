<?php
require 'DES.php';
require 'Wake.php';
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');

$kunci = $_POST['katakunci'];
$file_name = $_FILES['file']['name'];
$file_ext = substr($file_name, strpos($file_name, ".") + 1);
$file_size = $_FILES['file']['size'];

function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

if ($_FILES['file']['error'] != 0) {
	echo "<script>alert('Tidak ada file yang diupload')</script>";
	echo "<a href=?hal=enkrip><button class='btn btn-default' name='Kembali'>Kembali ke halaman dekripsi</button></a>";
	return;
}
if(strlen($kunci)<8){
	echo "<script>alert('Password kurang dari 8 karakter')</script>";
	echo "<a href=?hal=enkrip> <button class='btn btn-default' name ='Kembali'>Kembali ke halaman dekripsi</button> </a>";
	return;
}
if($file_ext != "xlsx" && $file_ext != "doc" && $file_ext != "docx" && $file_ext !="xls"){
	echo "<script>alert('File yang dipilih bukan file type word / Excel')</script>";
	echo "<a href=?hal=enkrip> <button class='btn btn-default' name ='Kembali'>Kembali ke halaman dekripsi</button> </a>";
	return;
}
if($file_size > 5000000){
	echo "<script>alert('File yang dipilih memiliki size lebih besar dari 5MB')</script>";
	echo "<a href=?hal=enkrip> <button class='btn btn-default' name ='Kembali'>Kembali ke halaman dekripsi</button> </a>";
	return;
}

$namafile =  "upload/" . $file_name;
$fp = fopen($namafile, "r");
$ciphertext = fread($fp, filesize($namafile));
$recovered_message = des ($kunci, $ciphertext, 0, 0, null, 0);
//echo hasil dekripsi
//echo $recovered_message;
//echo "</br>";

if (is_string($recovered_message[0]) === false && ctype_print($recovered_message[0]) === true) {
	echo "<script>alert('File yang dipilih bukan hasil enkripsi')</script>";
	echo "<a href=?hal=enkrip> <button name ='Kembali'>Kembali ke halaman dekripsi</button> </a>";
	return;
}

$namafile = str_replace("Enkrip","Dekrip", $_FILES["file"]["name"]);

/*simpan data di file*/
$fp = fopen("upload/" . $namafile, "w");
fwrite($fp, $recovered_message);
fclose($fp);
$time_end = microtime_float();
$time = $time_end - $time_start;

$filedekrip="upload/".$namafile;
?>

<div class="row">
    <div class="col-lg-6">
		<form role="form" action="?hal=unduh" method="post">
			<input type='hidden' name="file_name" value=" <?php echo $filedekrip; ?> ">
			<div class="form-group">
 	            <label>File Enkripsi : <?= $file_name ?></label> <br>
 	            <label>Size File Enkripsi : <?= $file_size / 1024 ?> KB</label> <br>
 	            <label>File Hasil Dekripsi : <?= $namafile ?></label> <br>
 	            <label>Size File Dekripsi : <?= filesize($filedekrip) / 1024 ?> KB</label> <br>
 	            <label>Waktu Proses Dekripsi : <?= $time ?> seconds</label>
            </div> 
            <button type="submit" class="btn btn-default" name="unduh">Unduh File</button>
            <button type="reset" class="btn btn-default" ><a href=?hal=enkrip>Cancel</button>
		</form>
	</div>
</div>