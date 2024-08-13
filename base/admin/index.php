<?php
define( "ROOTPATH", "../../" );
include( ROOTPATH."includes/admin.inc.php" );
include( "language/".$sLan.".php" );
needauth( 0 );
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $strAdminTitle; ?></title>
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	
	<!-- PAGE LEVEL PLUGINS STYLES -->
	<link rel="stylesheet" href="assets/css/plugins/colorBox/colorbox.css">
		
	<!-- REQUIRE FOR SPEECH COMMANDS -->
	<link rel="stylesheet" type="text/css" href="assets/css/plugins/gritter/jquery.gritter.css" />	

    <!-- Tc core CSS -->
	<link id="qstyle" rel="stylesheet" href="assets/css/themes/style.css">	
	
    <!-- Add custom CSS here -->

	<!-- End custom CSS here -->
	
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	<div id="wrapper">
		<div id="main-container">		
			<!-- BEGIN TOP NAVIGATION -->
				<nav class="navbar-top fixed" role="navigation">
					<!-- BEGIN BRAND HEADING -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".top-collapse">
							<i class="fa fa-bars"></i>
						</button>
						<div class="navbar-brand">
							<a href="index.php">
								<img src="assets/images/logo.png" alt="logo" class="img-responsive">
							</a>
						</div>
					</div>
					<!-- END BRAND HEADING -->
					<div class="nav-top">
						<!-- BEGIN RIGHT SIDE DROPDOWN BUTTONS -->
							<ul class="nav navbar-right">
								<li class="dropdown">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
										<i class="fa fa-bars"></i>
									</button>
								</li>
								<!--li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-envelope"></i> <span class="badge up badge-primary">2</span></a>
											<ul class="dropdown-menu dropdown-scroll dropdown-messages">
												<li class="dropdown-header">
													<i class="fa fa-envelope"></i> 2 筆新訊息
												</li>
												<li id="messageScroll">
													<ul class="list-unstyled">
														<li>
															<a href="#">
																<div class="row">
																	<div class="col-xs-2">
																		<img class="img-circle" src="assets/images/user-profile-1.jpg" alt="">
																	</div>
																	<div class="col-xs-10">
																		<p>
																			<strong>John Smith</strong>: Hi again! I wanted to let you know that the order...
																		</p>
																		<p class="small">
																			<i class="fa fa-clock-o"></i> 5 分鐘以前
																		</p>
																	</div>
																</div>
															</a>
														</li>
														<li>
															<a href="#">
																<div class="row">
																	<div class="col-xs-2">
																		<img class="img-circle" src="assets/images/user-profile-2.jpg" alt="">
																	</div>
																	<div class="col-xs-10">
																		<p>
																			<strong>Roddy Austin</strong>: Thanks for the info, if you need anything...
																		</p>
																		<p class="small">
																			<i class="fa fa-clock-o"></i> 3:39 PM
																		</p>
																	</div>
																</div>
															</a>
														</li>
													</ul>
												</li>
												<li class="dropdown-footer">
													<a href="#">
														觀看所有訊息
													</a>
												</li>
											</ul>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-bell"></i> <span class="badge up badge-success">3</span>
									</a>
										<ul class="dropdown-menu dropdown-scroll dropdown-alerts">
											<li class="dropdown-header">
												<i class="fa fa-bell"></i> 3 筆新警告
											</li>
											<li id="alertScroll">
												<ul class="list-unstyled">
													<li>
														<a href="#">
															<div class="alert-icon bg-info pull-left">
																<i class="fa fa-download"></i>
															</div>
																Downloads <span class="badge badge-info pull-right">16</span>
														</a>
													</li>
													<li>
														<a href="#">
															<div class="alert-icon bg-success pull-left">
																<i class="fa fa-cloud-upload"></i>
															</div>
																Server #8 Rebooted <span class="small pull-right"><strong><em>12 hours ago</em></strong></span>
														</a>
													</li>
													<li>
														<a href="#">
															<div class="alert-icon bg-danger pull-left">
																<i class="fa fa-bolt"></i>
															</div>
																Server #8 Crashed <span class="small pull-right"><strong><em>12 hours ago</em></strong></span>
														</a>
													</li>
												</ul>
											</li>
											<li class="dropdown-footer">
												<a href="#">
													觀看所有警告
												</a>
											</li>
										</ul>
								</li-->
								<!--li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-tasks"></i> <span class="badge up badge-info">7</span>
									</a>
										<ul class="dropdown-menu dropdown-scroll dropdown-tasks">
											<li class="dropdown-header">
												<i class="fa fa-tasks"></i> 10 筆待處理任務
											</li>
											<li id="taskScroll">
												<ul class="list-unstyled">
													<li>
														<a href="#">
															<p>
																採購訂單 #439 <span class="pull-right"><strong>52%</strong></span>
															</p>
															<div class="progress progress-striped">
																	<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100" style="width: 52%;"></div>
															</div>
														</a>
													</li>
													<li>
														<a href="#">
															<p>
																商品內容更新 <span class="pull-right"><strong>14%</strong></span>
															</p>
															<div class="progress">
																<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100" style="width: 14%;"></div>
															</div>
														</a>
													</li>
													<li>
														<a href="#">
															<p>
																客戶數據清理 <span class="pull-right"><strong>68%</strong></span>
															</p>
															<div class="progress progress-striped">
																<div class="progress-bar" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
															</div>
														</a>
													</li>
													<li>
														<a href="#">
															<p>
																主機資料備份 <span class="pull-right"><strong>85%</strong></span>
															</p>
															<div class="progress">
																<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;"></div>
															</div>
														</a>
													</li>
													<li>
														<a href="#">
															<p>
																聯絡合作廠商 <span class="pull-right"><strong>66%</strong></span>
															</p>
															<div class="progress progress-striped active">
																<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%;"></div>
															</div>
														</a>
													</li>
												</ul>
											</li>
											<li class="dropdown-footer">
												<a href="#">
													觀看所有任務
												</a>
											</li>
										</ul>
								</li-->
								<!--Speech Icon-->
								<!--li class="dropdown">
									<a href="#" class="speech-button">
										<i class="fa fa-microphone"></i>
									</a>
								</li-->
								<!--Speech Icon-->
								<li class="dropdown user-box">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<img class="img-circle" src="<?php if($_COOKIE['SYSPIC'] == 'none'){echo ROOTPATH.'';}else{echo ROOTPATH.$_COOKIE['SYSPIC'];}?>" alt=""> <span class="user-info"><?php echo $_COOKIE["SYSNAME"]?></span> <b class="caret"></b>
									</a>
										<ul class="dropdown-menu dropdown-user">
											<li>
												<a href="javascript:;" id="modauth">
													<i class="fa fa-user"></i> 帳號管理
												</a>
											</li>
											<li>
												<a href="javascript:;" id="modpass">
													<i class="fa fa-gear"></i> 密碼設定
												</a>
											</li>		
											<li>
												<a href="javascript:;" id="pedit">
													<i class="fa fa-envelope"></i> <?php echo $strPlusEnter; ?>
												</a>
											</li>
											<li>
												<a href="javascript:;" id="preview">
													<i class="fa fa-tasks"></i> <?php echo $strPlusExit; ?>
												</a>
											</li>									
											<li>
												<a href="javascript:;" id="pdv_logout">
													<i class="fa fa-power-off"></i> <?php echo $strAdminExit; ?>
												</a>
											</li>
										</ul>
								</li>
								<!--Search Box-->
								<!--li class="dropdown nav-search-icon">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<span class="glyphicon glyphicon-search"></span>
									</a>
									<ul class="dropdown-menu dropdown-search">
										<li>
											<div class="search-box">
												<form class="" role="search">
													<input type="text" class="form-control" placeholder="訂單搜尋" />
												</form>
											</div>
										</li>
									</ul>
								</li-->
								<!--Search Box-->
							</ul>
						<!-- END RIGHT SIDE DROPDOWN BUTTONS -->							
						<!-- BEGIN TOP MENU -->
							<div id="topmenu" class="collapse navbar-collapse top-collapse">
								<!-- .nav -->
								<ul class="nav navbar-left navbar-nav">
									<li><a href="javascript:;" onClick="document.getElementById('mainframe').src='main.php'"><?php echo $strAdminMenu1; ?> <!--span class="badge badge-primary">New</span--></a></li>
									<li><a href="javascript:;" onClick="document.getElementById('mainframe').src='config.php'"><?php echo $strAdminSet; ?></a></li>
<?php
#呼叫後台模組項目#
$i = 3;
$msql->query( "select * from {P}_base_coltype where ifadmin='1' order by id" );
while ( $msql->next_record( ) )
{
		$coltype = $msql->f( "coltype" );
		$sname = $msql->f( "sname" );
		if( $_COOKIE["SYSUSER"] != "wayhunt" && $_COOKIE["SYSUSER"] != "eric" && $coltype == "adminmenu"){ 
			
		}else{
			echo "<li><a id='menu".$i."' href=\"javascript:;\" onClick=\"document.getElementById('thiscoltype').value='';document.getElementById('mainframe').src='".ROOTPATH.$coltype."/admin/index.php'\">".$sname."</a></li>";
		}
		$i++;
}
?>
								</ul><!-- /.nav -->
							</div>
						<!-- END TOP MENU -->
					</div><!-- /.nav-top -->
				</nav><!-- /.navbar-top -->
				<!-- END TOP NAVIGATION -->

				
				<!-- BEGIN SIDE NAVIGATION -->				
				<!--nav class="navbar-side fixed sidebar-light" role="navigation"-->
				<nav class="navbar-side fixed" role="navigation">
					<div id="sidemenu" class="navbar-collapse sidebar-collapse collapse">
						<!-- 目前選單模組 -->
						<input type="hidden" id="thiscoltype" value="" />
						<!-- BEGIN SHORTCUT BUTTONS -->
						<div class="media">							
							<ul class="sidebar-shortcuts">
								<li><a class="btn" title="會員管理" href="javascript:;" onClick="document.getElementById('mainframe').src='../../member/admin/index.php'"><i class="fa fa-user icon-only"></i></a></li>
								<li><a class="btn" title="電子報" href="javascript:;" onClick="document.getElementById('mainframe').src='../../paper/admin/index.php'"><i class="fa fa-envelope icon-only"></i></a></li>
								<li><a class="btn" title="訂單查詢" href="javascript:;" onClick="document.getElementById('mainframe').src='../../shop/admin/order.php'"><i class="fa fa-th icon-only"></i></a></li>
								<li><a class="btn" title="網站設置" href="javascript:;" onClick="document.getElementById('mainframe').src='config.php'"><i class="fa fa-gear icon-only"></i></a></li>
							</ul>	
						</div>
						<!-- END SHORTCUT BUTTONS -->	
							
						<!-- BEGIN FIND MENU ITEM INPUT -->
						<div class="media-search">	
							<input type="text" class="input-menu" id="input-items" placeholder="功能找尋...">
						</div>						
						<!-- END FIND MENU ITEM INPUT -->
						
						<ul id="side" class="nav navbar-nav side-nav menulist">
							<!-- BEGIN SIDE NAV MENU -->
							
						</ul><!-- /.side-nav -->
						
					</div><!-- /.navbar-collapse -->
				</nav><!-- /.navbar-side -->
				<!-- END SIDE NAVIGATION -->
				

				<!-- BEGIN MAIN PAGE CONTENT -->
				<div id="page-wrapper">
					<!-- BEGIN PAGE HEADING ROW -->
						<div class="row">
							<div class="col-lg-12">
								<!-- BEGIN BREADCRUMB -->
								<div class="breadcrumbs">
									<ul class="breadcrumb" id="breadcrumb">
										
									</ul>
									
									<div class="b-right hidden-xs">
										<!--ul>
											<li><a href="#" title=""><i class="fa fa-signal"></i></a></li>
											<li><a href="#" title=""><i class="fa fa-comments"></i></a></li>
											<li class="dropdown"><a href="#" title="" data-toggle="dropdown"><i class="fa fa-plus"></i><span> 任務</span></a>
												<ul class="dropdown-menu dropdown-primary dropdown-menu-right">
													<li><a href="#">新增一個任務</a></li>
													<li><a href="#">任務說明</a></li>
													<li><a href="#">相關設定</a></li>
												</ul>
											</li>
										</ul-->
									</div>
								</div>
								<!-- END BREADCRUMB -->	
								
								<div class="page-header title">
								<!-- PAGE TITLE ROW -->
									<h1 id="pagetitle"> <span class="sub-title" id="subtitle"></span></h1>								
								</div>
								
							</div><!-- /.col-lg-12 -->
						</div><!-- /.row -->
					<!-- END PAGE HEADING ROW -->					
						<div class="row">
							<div class="row">
								<iframe src='main.php' style="margin:0px 0px;padding:0px;height:100%;width:100%;overflow: hidden;min-height:700px;" id='mainframe' name='mainframe' width="100%" scrolling="no" marginheight='0'  frameborder='0' class="autoHeight">IE</iframe>
								<!-- START YOUR CONTENT HERE -->
								<!--p>This is a light-weight blank page, with minimum to none plugins loaded</p>
								<!-- END YOUR CONTENT HERE -->
					
							</div>
						</div>
						
					<!-- BEGIN FOOTER CONTENT -->		
						<div class="footer">
							<div class="footer-inner">
								<!-- basics/footer -->
								<div class="footer-content">
									&copy; 2016 <a href="<?php echo $strCplusUrl; ?>" target="_blank"><?php echo $strCplusName; ?></a>, All Rights Reserved.
								</div>
								<!-- /basics/footer -->
							</div>
						</div>
						<button type="button" id="back-to-top" class="btn btn-primary btn-sm back-to-top">
							<i class="fa fa-angle-double-up icon-only bigger-110"></i>
						</button>
					<!-- END FOOTER CONTENT -->
					
				</div><!-- /#page-wrapper -->	  
			<!-- END MAIN PAGE CONTENT -->
		</div>  
	</div> 

    
    <!-- core JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/plugins/pace/pace.min.js"></script>
	<script src="assets/js/plugins/iframeautoheight/jquery.autoheight.js"></script>
	<script src="assets/js/plugins/iframeautoheight/iframeResizer.min.js"></script>
	<script src="assets/js/main.js?1"></script>
	<script src="assets/js/plugins/colorBox/jquery.colorbox-min.js"></script>
	
	<!--2016-05-27 Dylan add-->
	<script  language="javascript">
		var PDV_RP="<?php echo ROOTPATH; ?>";
	</script>
	<script src="js/main.js"></script>
  </body>
</html>