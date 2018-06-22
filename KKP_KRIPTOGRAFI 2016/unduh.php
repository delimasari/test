<?php
$file=basename($_POST['file_name']);
$fileenkrip='upload/'.$file;

if (file_exists($fileenkrip)) {
    header('Content-Description: File Transfer');
    header("Cache-Control: public"); // needed for internet explorer
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Disposition: attachment; filename=$file");
    header('Content-Length: ' . filesize($fileenkrip));

    // add these two lines
	ob_clean();   // discard any data in the output buffer (if possible)
	flush();      // flush headers (if possible)

    readfile($fileenkrip);
    exit;
}
?>