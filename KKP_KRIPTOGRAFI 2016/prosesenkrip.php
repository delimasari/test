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
	echo "<a href=?hal=enkrip><button class='btn btn-default' name='Kembali'>Kembali ke halaman enkripsi</button></a>";
	return;
}
if(strlen($kunci)<8){
	echo "<script>alert('Password kurang dari 8 karakter')</script>";
	echo "<a href=?hal=enkrip> <button class='btn btn-default' name ='Kembali'>Kembali ke halaman enkripsi</button> </a>";
	return;
}
if($file_ext != "xlsx" && $file_ext != "doc" && $file_ext != "docx" && $file_ext !="xls"){
	echo "<script>alert('File yang dipilih bukan file type Word / Excel)</script>";
	echo "<a href=?hal=enkrip> <button class='btn btn-default' name ='Kembali'>Kembali ke halaman enkripsi</button> </a>";
	return;
}
if($file_size > 5000000){
	echo "<script>alert('File yang dipilih memiliki size lebih besar dari 5MB')</script>";
	echo "<a href=?hal=enkrip> <button class='btn btn-default' name ='Kembali'>Kembali ke halaman enkripsi</button> </a>";
	return;
}

$target_path = 'upload/temp/' . basename( $_FILES['file']['name']);
move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
$kalimat = file_get_contents($target_path);
$ciphertext = des ($kunci, $kalimat, 1, 0, null, 0);
// echo "hasil enkripsi</br>";
// echo $ciphertext;
// echo "</br>";
$wake = new Wake();


/*Menyimpan File yang di enkripsi*/
move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['type']);
$namafile =$_FILES['file']['name'];

/*simpan data di file*/
$fp = fopen("upload/Enkrip_".$namafile,"w");
fwrite($fp, $ciphertext);
fclose($fp);
$time_end = microtime_float();
$time = $time_end - $time_start;

$enkrip="Enkrip_".$namafile;
$fileenkrip="upload/".$enkrip;
?>

<div class="row">
    <div class="col-lg-6">
		<form role="form" action="?hal=unduh" method="post">
			<input type='hidden' name="file_name" value=" <?php echo $fileenkrip; ?> ">
			<div class="form-group">
 	            <label>File Original : <?= $file_name ?></label> <br>
 	            <label>Size File Original : <?= $file_size / 1024 ?> KB</label> <br>
 	            <label>File Hasil Enkripsi : <?= $enkrip ?></label> <br>
 	            <label>Size File Enkripsi : <?= filesize($fileenkrip) / 1024 ?> KB</label> <br>
 	            <label>Waktu Proses Enkripsi : <?= $time ?> seconds</label>
            </div> 
            <button type="submit" class="btn btn-default" name="unduh">Unduh File</button>
            <button type="reset" class="btn btn-default" ><a href=?hal=enkrip>Cancel</button>
		</form>
	</div>
</div>