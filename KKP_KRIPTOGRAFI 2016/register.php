<div class="row">
    <div class="col-lg-6">
		<form role="form" action="register_proses.php" method="post" name="Input File" enctype="multipart/form-data">
			<div class="form-group">
            <legend id="legend"><img src="images/1help.png" /></legend>
 	            <label>Username </label>
                <input type="text" name="username" class="form-control" required/>
            </div>  
			<div class="form-group">
                <label>Password </label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Selects</label>
                    <select name="level" class="form-control" required>
                        <option value="">__pilih__</option>
                        <option value="admin">Admin</option>
                       	<option value="user">User</option>
  					</select>
             </div>
            <button type="submit" class="btn btn-default" name="enkripsi">Register</button>
            <button type="reset" class="btn btn-default">Cancel</button>
		</form>
	</div>
</div>