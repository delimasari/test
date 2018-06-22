<?php
session_start();
if($_SESSION['level']=="admin" or $_SESSION['level']=="user"){
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>APLIKASI PENGAMAN DATA PT. TASSINDO TASSA INDUSTRIES</title>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<script type="text/javascript">
function resetElement(tes){
documents.getElementsByName(tes).visibility='none';===
}
</script>
<body>
	 <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar" href="home.php"><font size="5" color="black" font face="tahoma"><b> -   APLIKASI PENGAMANAN DATA PT. TASINDO TASSA INDUSTRIES   -</b></font></a>
            </div>    
    		<ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <font size="4" font face="tahoma">
                    <br>
                	<?php
                		echo 'Selamat datang, <b>'.$_SESSION['tampilnama'].'</b>'
                	?>
                    </font>
                        </li>
                    </ul>
                </li>
            </ul>

             <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="?hal=utama"><i class="fa fa-home fa-fw"></i><b> Home</b></a>
                        </li>
                         <li>
                            <a href="?hal=enkrip"><i class="fa fa-tasks fa-fw"></i><b> Enkripsi</b></a>
                        </li>
                        <li>
                            <a href="?hal=dekrip"><i class="fa fa-tasks fa-fw"></i><b> Dekripsi</b></a>
                        </li>
                        <?php if ($_SESSION['level']=="admin"){ ?>
						<li>
                            <a href="?hal=register"><i class="fa fa-edit fa-fw"></i><b> Register</b></a>
                        </li>
						<?php } ?>
                        <li>
                            <a href="?hal=help"><i class="fa fa-wrench fa-fw"></i><b> Help</b></a>
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i><b> Logout</b></a>
                        </li>
                 
                    </ul>
                </div>
            </div>
        </nav>

         <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                 <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                   
                        <div class="panel-body">
                           
                                        
					                  <?php
												if(isset($_GET['hal'])) { 
												$hal = $_GET['hal'];
												} else { 
													$hal = "utama";
												}
												switch ($hal) {
													case	'enkrip'			: include "enkrip.php"; break;
													case	'dekrip'			: include "dekrip.php"; break;
													case	'help'				: include "help.php"; break;
													case	'register'			: include "register.php"; break;
													case	'prosesenkrip'		: include "prosesenkrip.php"; break;
													case	'prosesdekrip'		: include "prosesdekrip.php"; break;
                                                    case    'unduh'      : include "unduh.php"; break;
													
																		
													default : include "utama.php";
												}		
									?>          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="dist/js/sb-admin-2.js"></script>
</body>
</html>							

<?php

}else{
	header('location:index.php');
} ?>