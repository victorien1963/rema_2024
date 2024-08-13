<?php
define( "ROOTPATH", "" );
include( ROOTPATH."includes/admin.inc.php" );
include( "base/language/".$sLan.".php" );
if($_COOKIE["SYSUSER"] != ""){
	header("Location: base/admin/index.php"); 
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $strAdminTitle;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="base/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="base/admin/assets/css/fonts.css">
	<link rel="stylesheet" href="base/admin/assets/font-awesome/css/font-awesome.min.css">

    <!-- Tc core CSS -->
	<link id="qstyle" rel="stylesheet" href="base/admin/assets/css/themes/style.css">
	
    <!--[if lt IE 9]>
    <script src="base/admin/assets/js/html5shiv.js"></script>
    <script src="base/admin/assets/js/respond.min.js"></script>
    <![endif]-->
	
  </head>

  <body class="login">
	<div id="wrapper">
			<!-- BEGIN MAIN PAGE CONTENT -->
			
			<div class="login-container">
				<h2>
					<a href="index.php"><img src="base/admin/assets/images/logo.png" alt="logo" class="img-responsive"></a><!-- can use your logo-->
				</h2>
				<!-- BEGIN LOGIN BOX -->
				<div id="login-box" class="login-box visible">					
					<p class="bigger-110">
						<i class="fa fa-key"></i> 請輸入您的管理員帳號密碼
					</p>
					
					<div class="hr hr-8 hr-double dotted"></div>
					
					<form action="" method="post" id="adminLoginForm">
						<div class="form-group">
							<div class="input-icon right">
								<span class="fa fa-key text-gray"></span>
								<input type="text" name="user" class="form-control" placeholder="<?php echo $strAdminUser;?>">
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
								<span class="fa fa-lock text-gray"></span>
								<input type="password" name="password" class="form-control" placeholder="<?php echo $strAdminPass;?>">
							</div>
						</div>
						<div class="tcb">
							<label>
								<input type="tel" id="ImgCode" name="ImgCode" style="width:80%" placeholder="<?php echo $strAdminImg;?>">
							</label>
							<button type="submit" class="pull-right btn btn-primary"><?php echo $strAdminSubmit;?><i class="fa fa-key icon-on-right"></i></button>
							<div class="clearfix"></div>
						</div>				
						
						<div class="social-or-login">
							<span class="text-primary">圖 形 驗 證 碼</span>
						</div>
							
						<div class="space-4"></div>
						
						<div class="text-center">
							<img id="codeimg" src="codeimg.php" width="115" height="44" style="border:1px #dddddd solid;cursor:pointer" align="absmiddle"/>
							<input name="act" type="hidden" id="act" value="adminlogin">
						</div>

						<div class="footer-wrap">
							<span class="pull-left">
								REMA 網站平台管理系統 v<?php echo PHPWEB_VERSION; ?>
							</span>
							
							<span class="pull-right">
								<div id="notice" class="alert bg-primary"></div>
							</span>
							
							<div class="clearfix"></div>
						</div>							
					</form>
				</div>
				<!-- END LOGIN BOX -->
			</div>

			<!-- END MAIN PAGE CONTENT --> 
	</div> 

	 
    <!-- core JavaScript -->
    <script src="base/admin/assets/js/jquery.min.js"></script>
	
	<!-- PAGE LEVEL PLUGINS JS -->
	
	<script src="base/js/form.js"></script>
	<script src="base/js/admin.js"></script>	
  </body>
</html>