<div class="row">
    <div class="col-lg-6">
		<form role="form" action="?hal=prosesdekrip" method="post" name="Input File" enctype="multipart/form-data">
			<div class="form-group">
            <legend id="legend"><img src="images/dekrip.png" /></legend>
 	            <label>Pilih File :</label>
                <input type="file" class='btn btn-default' name="file">
            </div>  
			<div class="form-group">
                <label>Password </label>
                <input type="password" name="katakunci" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-default" name="enkripsi">Dekripsi File</button>
            <button type="reset" class="btn btn-default"><a href=?hal=enkrip>Cancel</button>
		</form>
	</div>
</div>