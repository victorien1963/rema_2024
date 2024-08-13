<?php

define( "ROOTPATH", "../../" );

include( ROOTPATH."includes/admin.inc.php" );

include( ROOTPATH."includes/pages.inc.php" );

include( "language/".$sLan.".php" );

include( "func/member.inc.php" );

needauth( 52 );



				/*$msql->query( "select * from {P}_member" );

				while ( $msql->next_record( ) )

				{

						$adda = substr($msql->f( "addr" ),0,9);

						$addb = substr($msql->f( "addr" ),9,9);

						$countryid = $msql->f( "countryid" );

						$mid = $msql->f( "memberid" );

						if($addb != ""){

							$getz = $tsql->getone("SELECT * FROM {P}_member_zone WHERE cat regexp '$addb'");

							$getzid = $getz['catid'];

							if($countryid == "1"){

								$fsql->query( "update {P}_member set zoneid='$getzid' where memberid='{$mid}'" );

								echo("//".$getzid."//".$mid."");

							}

						}

				}*/



$step = $_REQUEST['step'];

$page = $_REQUEST['page'];

$sc = $_REQUEST['sc'];

$ord = $_REQUEST['ord'];

$membertypeid = $_REQUEST['membertypeid'];

$memberid = $_REQUEST['memberid'];

$key = trim($_REQUEST['key']);

$user = $_REQUEST['user'];

$shownum = $_REQUEST['shownum'];

$showcheck = $_REQUEST['showcheck'];

$showrz = $_REQUEST['showrz'];

$newtypeid = $_REQUEST['newtypeid'];

$searchmd = $_REQUEST['searchmd'];

if ( !isset( $shownum ) || $shownum < 10 )

{

		$shownum = 10;

}

if ( !isset( $searchmd ) || $searchmd == "" )

{

		$searchmd = "common";

}

$xn = $_REQUEST['xn'];

if ( !isset( $xn ) || $xn == "" )

{

		$xn = "1";

}



if($step=="000"){

		set_time_limit(0);

		//載入 PHPEXCEL

		include_once("func/Classes/PHPExcel.php");

		include_once("func/Classes/PHPExcel/IOFactory.php");

		// Create new PHPExcel object

		$objPHPExcel = new PHPExcel();

		// 設置屬性

		$objPHPExcel->getProperties()->setCreator("測試作者")//作者

		   ->setLastModifiedBy("測試修改者")//最後修改者

		   ->setTitle("測試標題")//標題

		   ->setSubject("測試主旨")//主旨

		   ->setDescription("測試註解")//註解

		   ->setKeywords("測試標記")//標記

		   ->setCategory("測試類別");//類別

		//Create a first sheet

		$objPHPExcel->setActiveSheetIndex(0);

		//設定欄位寬度

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);

		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);

		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);

		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);

		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);

		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);



		//行號

		$excel_line = 1;



		//產生第一列

		$objPHPExcel->getActiveSheet()->setCellValue("A{$excel_line}", "姓名");

		$objPHPExcel->getActiveSheet()->setCellValue("B{$excel_line}", "性別");

		$objPHPExcel->getActiveSheet()->setCellValue("C{$excel_line}", "國家");

		$objPHPExcel->getActiveSheet()->setCellValue("D{$excel_line}", "地區");

		$objPHPExcel->getActiveSheet()->setCellValue("E{$excel_line}", "歲數");

		$objPHPExcel->getActiveSheet()->setCellValue("F{$excel_line}", "消費累積金額");

		$objPHPExcel->getActiveSheet()->setCellValue("G{$excel_line}", "購買次數");



	$li_a = ($xn-1)*1000;



	$msql->query( "select * from {P}_member where membertypeid='1' order by memberid asc limit $li_a,1000" );

	while($msql->next_record()){

				$e_memberid= $msql->f( "memberid" );

				$e_name= $msql->f( "name" )."(ID:".$e_memberid.")";

				$e_sex= $msql->f( "sex" )==1? "男":"女";

				$e_country= $msql->f( "country" );

				$e_birthday= $msql->f( "birthday" )? date("Y")-substr($msql->f( "birthday" ),0,4):"";

				if($e_birthday>100 || $e_birthday<0){

					$e_birthday="";

				}

				$e_zoneid= $msql->f( "zoneid" );

				$getzone = $fsql->getone( "select cat,pid from {P}_member_zone where catid='$e_zoneid'" );

				$e_zone = $getzone["cat"];

				$e_pid = $getzone["pid"];

				if($e_pid>0){

					$getFzone = $fsql->getone( "select cat from {P}_member_zone where catid='$e_pid'" );

					$e_zone = $getFzone["cat"].$e_zone;

				}

				//消費累積金額

				$getnum=0;

				$totalpay=0;

				$fsql->query( "select paytotal from {P}_shop_order where memberid='$e_memberid' and ifok='1'" );

				while($fsql->next_record()){

					$totalpay += $fsql->f( "paytotal" );

					$getnum++;

				}

				$e_paytotal = $totalpay;

				$e_count = $getnum;

				

				$excel_line++;

				//產生其他列

				$objPHPExcel->getActiveSheet()->setCellValue("A{$excel_line}", $e_name);

				$objPHPExcel->getActiveSheet()->setCellValue("B{$excel_line}", $e_sex);

				$objPHPExcel->getActiveSheet()->setCellValue("C{$excel_line}", $e_country);

				$objPHPExcel->getActiveSheet()->setCellValue("D{$excel_line}", $e_zone);

				$objPHPExcel->getActiveSheet()->setCellValue("E{$excel_line}", $e_birthday);

				$objPHPExcel->getActiveSheet()->setCellValue("F{$excel_line}", $e_paytotal);

				$objPHPExcel->getActiveSheet()->setCellValue("G{$excel_line}", $e_count);

		

	}

		

		//產生Excel

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//20003格式

		// We'll be outputting an excel file

		//header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls

		//$e_filename = date('YmdHis',time()).'_member.xls';

		//header('Content-Disposition: attachment; filename="'.$e_filename.'"');

		// Write file to the browser

		//$objWriter->save('php://output');		

		$objWriter->save("../xls/m".$xn.".xls");

		$xn++;

		//exit;

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head >

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link  href="css/style.css" type="text/css" rel="stylesheet">

<script type="text/javascript" src="../../base/js/base.js"></script>

<script type="text/javascript" src="../../base/js/form.js"></script>

<script type="text/javascript" src="../../base/js/blockui.js"></script>

<script type="text/javascript" src="js/member.js"></script>

<script src="js/frame.js"></script>

<title><?php echo $strAdminTitle; ?></title>

<SCRIPT>

function ordsc(nn,sc){

if(nn!='<?php echo $ord; ?>'){

	window.location='index.php?page=<?php echo $page; ?>&sc=<?php echo $sc; ?>&shownum=<?php echo $shownum; ?>&showcheck=<?php echo $showcheck; ?>&showrz=<?php echo $showrz; ?>&membertypeid=<?php echo $membertypeid; ?>&searchmd=<?php echo $searchmd; ?>&ord='+nn;

}else{

	if(sc=='asc' || sc==''){

	window.location='index.php?page=<?php echo $page; ?>&shownum=<?php echo $shownum; ?>&showcheck=<?php echo $showcheck; ?>&showrz=<?php echo $showrz; ?>&sc=desc&membertypeid=<?php echo $membertypeid; ?>&searchmd=<?php echo $searchmd; ?>&ord='+nn;

	}else{

	window.location='index.php?page=<?php echo $page; ?>&shownum=<?php echo $shownum; ?>&showcheck=<?php echo $showcheck; ?>&showrz=<?php echo $showrz; ?>&sc=asc&membertypeid=<?php echo $membertypeid; ?>&searchmd=<?php echo $searchmd; ?>&ord='+nn;

	}

}

}



function SelAll(theForm){

		for ( i = 0 ; i < theForm.elements.length ; i ++ )

		{

			if ( theForm.elements[i].type == "checkbox" && theForm.elements[i].name != "SELALL" )

			{

				theForm.elements[i].checked = ! theForm.elements[i].checked ;

			}

		}

}



function checkform(theform){

  if(theform.newuser.value=='<?php echo $strAddMemberInput; ?>' || theform.newuser.value=='')

  {

    alert("<?php echo $strAddMemberInput; ?>");

	theform.newuser.focus();

    return false;

  }  



  return true;

}  

</script>

	<script>

		$(document).ready(function(){

			//載入時隱藏選單

			$('#sidemenu, #topmenu', window.parent.document).removeClass('in');

			//頁面麵包屑

			$('#breadcrumb', window.parent.document).html('<li><a href="../../base/admin/index.php">Home</a></li><li>會員</li>');

			$('#pagetitle', window.parent.document).html('會員管理 <span class="sub-title" id="subtitle">會員查詢管理</span>');

			//呼叫左側功能選單

			$().getMenuGroup('member');

		});

	</script>

</head>



<body>



<?php

if ( $step == "delall" )

{

		trylimit( "_member", 500, "memberid" );

		needauth( 60 );

		$dall = $_POST['dall'];

		$nums = sizeof( $dall );

		

		for ( $i = 0;	$i < $nums;	$i++	)

		{

				$delmemberid = $dall[$i];

				$msql->query( "delete from {P}_member_rights where memberid='{$delmemberid}'" );

				$msql->query( "delete from {P}_member_nums where memberid='{$delmemberid}'" );

				$msql->query( "delete from {P}_member_fav where memberid='{$delmemberid}'" );

				$msql->query( "delete from {P}_member_pay where memberid='{$delmemberid}'" );

				$msql->query( "delete from {P}_member_buylist where memberid='{$delmemberid}'" );

				$msql->query( "delete from {P}_member where memberid='{$delmemberid}'" );

				$msql->query( "delete from {P}_paper_order where member_id='{$delmemberid}'" );

		}

}

if ( $step == "rzall" )

{

		trylimit( "_member", 500, "memberid" );

		needauth( 59 );

		$dall = $_POST['dall'];

		$nums = sizeof( $dall );

		

		for ( $i = 0;	$i < $nums;	$i++	)

		{

				$ids = $dall[$i];

				$msql->query( "update {P}_member set rz='1' where memberid='{$ids}'" );

		}

}

if ( $step == "unrzall" )

{

		trylimit( "_member", 500, "memberid" );

		needauth( 59 );

		$dall = $_POST['dall'];

		$nums = sizeof( $dall );

		

		for ( $i = 0;	$i < $nums;	$i++	)

		{

				$ids = $dall[$i];

				$msql->query( "update {P}_member set rz='0' where memberid='{$ids}'" );

		}

}

if ( $step == "chtypeall" )

{



		trylimit( "_member", 500, "memberid" );

		needauth( 64 );

		$dall = $_POST['dall'];

		$nums = sizeof( $dall );

		

		for ( $i = 0;	$i < $nums;	$i++	)

		{

				$ids = $dall[$i];

				$msql->query( "select membergroupid from {P}_member_type where membertypeid='{$newtypeid}'" );

				if ( $msql->next_record( ) )

				{

						$newmembergroupid = $msql->f( "membergroupid" );

				}

				$msql->query( "update {P}_paper_order set member_type='{$newtypeid}' where member_id='{$ids}'" );

				$msql->query( "update {P}_member set membertypeid='{$newtypeid}',membergroupid='{$newmembergroupid}' where memberid='{$ids}'" );

				default2member( $ids, $newtypeid );

		}

}

if ( $step == "addmember" )

{

		trylimit( "_member", 200, "memberid" );

		$newuser = trim($_REQUEST['newuser']);

		$newusername = $_REQUEST['newusername']? trim($_REQUEST['newusername']):trim($_REQUEST['newuser']);

		$newmobi = trim($_REQUEST['newmobi']);

		

		if($newmobi ==""){

			err("請填寫手機號碼","","");

			exit();

		}



		$msql->query( "select membergroupid from {P}_member_type where membertypeid='{$membertypeid}'" );

		if ( $msql->next_record( ) )

		{

				$nowmembergroupid = $msql->f( "membergroupid" );

		}

		$msql->query( "select * from {P}_member where user='{$newuser}'" );

		if ( $msql->next_record( ) )

		{

				err( $strAddMemberNTC3, "index.php?membertypeid=".$membertypeid, "" );

				exit( );

		}

		/*$newpass = "";

		

		for ( $i = 1;	$i <= 9;	$i++	)

		{

				$zz = rand( 0, 9 );

				$newpass .= $zz;

		}*/

		$mdnewpass = md5( $newmobi );

		$now = time( );

		$ip = $_SERVER['REMOTE_ADDR'];

		$msql->query( "insert into {P}_member set



				   membertypeid='{$membertypeid}',

				   membergroupid='{$nowmembergroupid}',

				   user='{$newuser}',

				   password='{$mdnewpass}',

				   name='{$newusername}',

				   pname='{$newuser}',

				   sex='',

				   birthday='0',

				   zoneid='0',

				   addr='',

				   tel='',

				   mov='',

				   postcode='',

				   email='{$newuser}',

				   url='',

				   passtype='',

				   passcode='',

				   qq='',

				   msn='',

				   maillist='0',

				   bz='',

				   checked='1',

				   regtime='{$now}',

				   exptime='0',

				   account='0',

				   paytotal='0',

				   buytotal='0',

				   ip='{$ip}',

				   logincount='0',

				   logintime='{$now}',

				   loginip='{$ip}'



				

				" );

		$newmemberid = $msql->instid( );

		default2member( $newmemberid, $membertypeid );

		/*自動寄發通知信，告知密碼*/

		$fsql->query( "select * from {P}_member_type where membertypeid='{$membertypeid}'" );

		if ( $fsql->next_record( ) )

		{

			$regxy = $fsql->f( "regxy" );

		}

		$regmail = str_replace( "{#user#}", $newusername, $regxy );

		$regmail = str_replace( "{#email#}", $newuser, $regmail );

		$regmail = str_replace( "{#password#}", $newmobi, $regmail );

		

		include( ROOTPATH."includes/ebmail.inc.php" );

				

		$message = $regmail;

		$mailbody .='<table style="display: inline-table;" border="0" cellpadding="0" cellspacing="0" width="100%">';

		$mailbody .='<tr><td><img name="n1_r1_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_top_reg.png" width="800" height="208" alt=""></td></tr>';

		$mailbody .='<tr><td width="100%" valign="top" style="padding:0px;">';

		$mailbody .='<table width="800" border="0" align="left" cellpadding="0" cellspacing="0"><tr><td width="80" height="250">&nbsp;</td>';

		$mailbody .='<td width="400" style="font-family:\'微軟正黑體\',Century Gothic;vertical-align: top;font-size:17px;word-break: break-all;">'.$message.'</td><td width="80">&nbsp;</td>';

		$mailbody .='<td style="vertical-align: top;"><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_right_reg.png"></td></tr></table>';

		$mailbody .='</td></tr><tr><td><img name="n1_r3_c1" src="'.$GLOBALS['CONF']['SiteHttp'].'images/mail_bt.png" width="800" height="240" alt=""></td></tr></table>';

		$mailbody .='</body></html>';

		

		ebmail( $newuser, $GLOBALS['CONF']['SiteEmail'], "REMA官網會員自動註冊通知信", $mailbody );

		

		/**/

}



/*加入黑名單*/

if($step=="addblack"){

		$dall = $_REQUEST['dall'];

		$notice = $_REQUEST['notice'];

		$nums = sizeof( $dall );		

		for ( $i = 0;	$i < $nums;	$i++	)

		{

				$ids = $dall[$i];

				$msql->query( "SELECT * FROM {P}_member where memberid='{$ids}'" );

				if($msql->next_record()){

					$dmid = $msql->f("memberid");

					$dname = $msql->f("name");

					$dphone = $msql->f("mov");

					$daddr = $msql->f("addr");

					

					$fsql->query( "SELECT * FROM {P}_member_black where memberid='{$dmid}' and name='{$dname}' and phone='{$dphone}' and addr='{$daddr}' " );

					if(!$fsql->next_record()){

						//無相符則寫入

						$tsql->query( "INSERT INTO {P}_member_black SET memberid='{$dmid}',name='{$dname}',phone='{$dphone}',addr='{$daddr}',notice='{$notice}' " );

					}

				}

		}

}

?>



<div class="searchzone">

<table width="100%" border="0" cellspacing="0" cellpadding="3">

 

  <tr> 

      <td height="28"  > 

        <table border="0" cellspacing="1" cellpadding="0" width="100%">

           <tr> 

            <td> <form name="search" action="index.php" method="get"  style="float:left;">

			

			 

<select name="searchmd">

                <option value="common"  <?php echo seld( $searchmd, "common" ); ?>><?php echo $strMemberSModle1; ?></option>

                <option value="cent" <?php echo seld( $searchmd, "cent" ); ?>><?php echo $strMemberSModle2; ?></option>

				<option value="account" <?php echo seld( $searchmd, "account" ); ?>><?php echo $strMemberSModle3; ?></option>

              </select>

			

              

<select name="membertypeid" >

                <option value='0'><?php echo $strMemberTypeSel; ?></option>

<?php

$fsql->query( "select * from {P}_member_type  order by membertypeid" );

while ( $fsql->next_record( ) )

{

		$lmembertypeid = $fsql->f( "membertypeid" );

		$lmembertype = $fsql->f( "membertype" );

		if ( $membertypeid == $lmembertypeid )

		{

				echo "<option value='".$lmembertypeid."' selected>".$lmembertype."</option>";

		}

		else

		{

				echo "<option value='".$lmembertypeid."'>".$lmembertype."</option>";

		}

}

?>

              </select>

              

<select name="showrz">

                <option value="all" ><?php echo $strMemberRzStat; ?></option>

                <option value="1"  <?php echo seld( $showrz, "1" ); ?>><?php echo $strMemberRz1; ?></option>

                <option value="0" <?php echo seld( $showrz, "0" ); ?>><?php echo $strMemberRz0; ?></option>

              </select>

              

<select name="shownum">

                <option value="10"  <?php echo seld( $shownum, "10" ); ?>><?php echo $strSelNum10; ?></option>

                <option value="20" <?php echo seld( $shownum, "20" ); ?>><?php echo $strSelNum20; ?></option>

                <option value="30" <?php echo seld( $shownum, "30" ); ?>><?php echo $strSelNum30; ?></option>

                <option value="50" <?php echo seld( $shownum, "50" ); ?>><?php echo $strSelNum50; ?></option>

              </select>

              <input type="text" name="key" size="12"  class="input"  value="<?php echo $key; ?>" />

              <input type="submit" name="Submit" value="<?php echo $strSearchTitle; ?>" class="button" />

            

            </form>

            	

    

            	<form name="mform" action="index.php" method="get" style="float:left;margin-left:20px;">

           			<input type="hidden" name="step" value="000" />  

           			<input type="hidden" name="xn" value="<?php echo $xn; ?>" />  

           		   <button class="button" style="cursor:pointer;border:1px solid #000;" onclick="alert('輸出 m<?php echo $xn; ?>.xls');">輸出會員資料 <?php echo $xn; ?></button>

           	</form>

            	</td>

          </tr>

        </table>

    </td>

   

  

      <td align="right"  > 

 		<form name="adduser" method="post" action="index.php" onSubmit="return checkform(this)" />

        <input name="step" type="hidden" id="step" value="addmember" />

        <input name="newuser" type="text" class=input id="newuser" value="<?php echo $strAddMemberInput; ?>" size="26" onFocus="if(this.value=='<?php echo $strAddMemberInput; ?>'){this.value=''}" />

        <input name="newusername" type="text" class="input" id="newusername" value="<?php echo $strAddMemberInputName; ?>" size="12" onFocus="if(this.value=='<?php echo $strAddMemberInputName; ?>'){this.value=''}" />

        <input name="newmobi" type="text" class="input" id="newmobi" value="<?php echo $strAddMemberInputMobi; ?>" size="12" onFocus="if(this.value=='<?php echo $strAddMemberInputMobi; ?>'){this.value=''}" />

		

<select name="membertypeid" >

                

<?php

$fsql->query( "select * from {P}_member_type  order by membertypeid" );

while ( $fsql->next_record( ) )

{

		$lmembertypeid = $fsql->f( "membertypeid" );

		$lmembertype = $fsql->f( "membertype" );

		if ( $membertypeid == $lmembertypeid )

		{

				echo "<option value='".$lmembertypeid."' selected>".$lmembertype."</option>";

		}

		else

		{

				echo "<option value='".$lmembertypeid."'>".$lmembertype."</option>";

		}

}

?>

              </select>

		<input type="submit" name="Submit" value="<?php echo $strAddMember; ?>" class="button" />

     </form>

      </td> 

   

  </tr> 

</table>



</div>



<?php

if ( !isset( $ord ) || $ord == "" )

{

		$ord = "memberid";

}

if ( !isset( $sc ) || $sc == "" )

{

		$sc = "desc";

}

$scl = " memberid!='0' ";

if ( $membertypeid != "" && $membertypeid != "0" )

{

		$scl .= " and membertypeid='{$membertypeid}' ";

}



if ( $showcheck != "" && $showcheck != "all" )

{

		$scl .= " and checked='{$showcheck}' ";

}

if ( $showrz != "" && $showrz != "all" )

{

		$scl .= " and rz='{$showrz}' ";

}

if ( $key != "" )

{

		$scl .= " and (name regexp '{$key}' or pname regexp '{$key}' or company regexp '{$key}' or addr regexp '{$key}' or user regexp '{$key}' or tags regexp '{$key}' or mov regexp '{$key}' or email regexp '{$key}' )";

}

if( $memberid != "" ){

	$scl .= " and memberid='{$memberid}' ";

}

$totalnums = tblcount( "_member", "memberid", $scl );

$pages = new pages( );

$pages->setvar( array(

		"key" => $key,

		"shownum" => $shownum,

		"showcheck" => $showcheck,

		"showrz" => $showrz,

		"searchmd" => $searchmd,

		"ord" => $ord,

		"sc" => $sc,

		"membertypeid" => $membertypeid

) );

$pages->set( $shownum, $totalnums );
$pagelimit = $pages->limit( );
$page = explode(",", $pagelimit);
 //   echo $page[0];

switch ( $searchmd )

{

case "common" :

		$colcommon = "";

		$colcent = "display:none";

		$colaccount = "display:none";

		break;

case "cent" :

		$colcommon = "display:none";

		$colcent = "";

		$colaccount = "display:none";

		break;

case "account" :

		needauth( 68 );

		$colcommon = "display:none";

		$colcent = "display:none";

		$colaccount = "";

		$getacc = $msql->getone("SELECT SUM(account) FROM {P}_member");

		$allaccount = (INT)$getacc["SUM(account)"];

		break;

}

$msql->query( "select * from {P}_member_centset" );

if ( $msql->next_record( ) )

{

		$centname1 = $msql->f( "centname1" );

		$centname2 = $msql->f( "centname2" );

		$centname3 = $msql->f( "centname3" );

		$centname4 = $msql->f( "centname4" );

		$centname5 = $msql->f( "centname5" );

}

?>

<form name="delfm" method="post" action="index.php">

<div class="listzone">

<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">

          <tr> 

            

    <td height="28" width="30"  class="biaoti" align="center"><?php echo $strSel; ?></td>

            <td height="28" width="50"  class="biaoti" style="cursor:pointer" onClick="ordsc('memberid','<?php echo $sc; ?>')"><?php echo $strMemberNo; ordsc( $ord, "memberid", $sc ); ?>

</td>

            <td width="75" height="28"  class="biaoti" style="cursor:pointer" onClick="ordsc('membertypeid','<?php echo $sc; ?>')"><?php echo $strMemberType; ordsc( $ord, "membertypeid", $sc ); ?>

</td>

            <td width="80" height="28"  class="biaoti" style="cursor:pointer" onClick="ordsc('user','<?php echo $sc; ?>')"><?php echo $strMemberUser; ordsc( $ord, "user", $sc ); ?>

</td>

            <td class="biaoti" ><?php echo $strMemberFrom23; ?></td>

            <td width="80" class="biaoti"><?php echo $strMemberFrom4; ?></td>

            <td width="50"  class="biaoti"  style="cursor:pointer;<?php echo $colcent; ?>" onclick="ordsc('cent1','<?php echo $sc; ?>')"><?php echo $centname1; ordsc( $ord, "cent1", $sc ); ?>

</td>

            <td width="50"  class="biaoti"  style="cursor:pointer;<?php echo $colcent; ?>" onclick="ordsc('cent2','<?php echo $sc; ?>')"><?php echo $centname2; ordsc( $ord, "cent2", $sc ); ?>

</td>

            <td width="50"  class="biaoti"  style="cursor:pointer;<?php echo $colcent; ?>" onclick="ordsc('cent3','<?php echo $sc; ?>')"><?php echo $centname3; ordsc( $ord, "cent3", $sc ); ?>

</td>

            <td width="50"  class="biaoti"  style="cursor:pointer;<?php echo $colcent; ?>" onclick="ordsc('cent4','<?php echo $sc; ?>')"><?php echo $centname4; ordsc( $ord, "cent4", $sc ); ?>

</td>

            <td width="50"  class="biaoti"  style="cursor:pointer;<?php echo $colcent; ?>" onclick="ordsc('cent5','<?php echo $sc; ?>')"><?php echo $centname5; ordsc( $ord, "cent5", $sc ); ?>

</td>

            <td width="80"  class="biaoti"  style="cursor:pointer;<?php echo $colaccount; ?>" onclick="ordsc('account','<?php echo $sc; ?>')"><?php echo $strMemberAccounts; ordsc( $ord, "account", $sc ); ?>

</td>

            <td width="80"  class="biaoti"  style="cursor:pointer;<?php echo $colaccount; ?>" onclick="ordsc('paytotal','<?php echo $sc; ?>')"><?php echo $strMemberPayTotal; ordsc( $ord, "paytotal", $sc ); ?>

</td>

            <td width="80"  class="biaoti"  style="cursor:pointer;<?php echo $colaccount; ?>" onclick="ordsc('buytotal','<?php echo $sc; ?>')"><?php echo $strMemberBuyTotal; ordsc( $ord, "buytotal", $sc ); ?>

</td>

            <td width="65" height="28"  class="biaoti"  style="cursor:pointer;<?php echo $colcommon; ?>" onClick="ordsc('regtime','<?php echo $sc; ?>')"><?php echo $strMemberRegTime; ordsc( $ord, "regtime", $sc ); ?>

</td>

            <td  width="32" align="center"   class="biaoti"  style="<?php echo $colcommon; ?>"><?php echo $strMemberRz; ?></td>

            <td width="32"  class="biaoti" align="center" style="<?php echo $colaccount; ?>"><?php echo $strMemberAddAcc; ?></td>

            <td height="28" width="32"  class="biaoti" align="center" style="<?php echo $colcommon; ?>"><?php echo $strMemberMail; ?></td>

            <td width="32"  class="biaoti" align="center" style="<?php echo $colcent; ?>"><?php echo $strLook; ?></td>

            <td height="28" width="32"  class="biaoti" align="center" style="<?php echo $colcommon; ?>"><?php echo $strMemberDetail; ?></td>

			 <td height="28" width="32"  class="biaoti" align="center" style="<?php echo $colaccount; ?>"><?php echo $strMemberDetail; ?></td>

            <td width="32"  class="biaoti" align="center" style="<?php echo $colcommon; ?>"><?php echo $strMemberAuth; ?> </td>

            <td width="32"  class="biaoti" align="center"><?php echo $strMemberLogin; ?></td>

          </tr>

          

<?php
    //echo "SELECT count(*) AS total_number FROM `cpp_member` where {$scl} order by `regtime` {$sc}";
    /*$msql->query("SELECT count(*) AS total_number FROM `cpp_member` where {$scl} order by `regtime` {$sc}");
    while ( $msql->next_record( ) )
        $total = $msql->f("total_number");*/
    //echo $total;
$msql->query(
             "SELECT * FROM `cpp_member` where {$scl} order by `regtime` {$sc} limit {$pagelimit}");
	/*"SELECT *
	FROM (
		SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member 
		UNION ALL 
		SELECT `memberid`, `membertypeid`, `membergroupid`, `user`, `password`, `name`, `company`, `sex`, `birthday`, `zoneid`, `country`, `countryid`, `catid`, `addr`, `tel`, `mov`, `postcode`, `email`, `url`, `passtype`, `passcode`, `qq`, `msn`, `maillist`, `bz`, `pname`, `signature`, `memberface`, `nowface`, `checked`, `rz`, `tags`, `regtime`, `exptime`, `account`, `paytotal`, `buytotal`, `cent1`, `cent2`, `cent3`, `cent4`, `cent5`, `ip`, `logincount`, `logintime`, `loginip`, `salesname`, `chkcode`, `invoicename`, `invoicenumber`, `order_epaper`, `promo_id`, `tall`, `weight`, `chest`, `waist`, `hips`, `cardtoken` FROM cpp_member_offline
	) AS U
 	where {$scl} order by {$ord} {$sc} limit {$pagelimit}" );*/
    $total = $totalnums - $page[0];
while ( $msql->next_record( ) )

{
    
    
		$memberid = $msql->f( "memberid" );

		$mymembertypeid = $msql->f( "membertypeid" );

		$mymembergroupid = $msql->f( "membergroupid" );

		$user = $msql->f( "user" );

		$name = $msql->f( "name" );

		$company = $msql->f( "company" );

		$pname = $msql->f( "pname" );

		$tel = $msql->f( "tel" );

		$email = $msql->f( "email" );

		$checked = $msql->f( "checked" );

		$rz = $msql->f( "rz" );

		$ip = $msql->f( "ip" );

		$logincount = $msql->f( "logincount" );

		$regtime = $msql->f( "regtime" );

		$exptime = $msql->f( "exptime" );

		$cent1 = $msql->f( "cent1" );

		$cent2 = $msql->f( "cent2" );

		$cent3 = $msql->f( "cent3" );

		$cent4 = $msql->f( "cent4" );

		$cent5 = $msql->f( "cent5" );

		$account = $msql->f( "account" );

		$paytotal = $msql->f( "paytotal" );

		$buytotal = $msql->f( "buytotal" );

		$regtime = date( "y/n/j", $regtime );

		echo " 

          <tr class=\"list\"> 

            <td width=\"30\" align=\"center\" > 

              <input type=\"checkbox\" name=\"dall[]\" value=\"".$memberid."\">

            </td>

            <td   width=\"50\"> ".$total--." </td>

            <td width=\"75\" >".membertypeid2membertype( $mymembertypeid )."</td>

            <td width=\"80\"  > ".$user." </td>

            <td >".$company."</td>

            <td width=\"80\">".$name."</td>

            <td width=\"50\" style=\"".$colcent."\">".$cent1."</td>

            <td width=\"50\" style=\"".$colcent."\">".$cent2."</td>

            <td width=\"50\" style=\"".$colcent."\">".$cent3."</td>

            <td width=\"50\" style=\"".$colcent."\">".$cent4."</td>

            <td width=\"50\" style=\"".$colcent."\">".$cent5."</td>

            <td width=\"80\" style=\"".$colaccount."\">".$account."</td>

            <td width=\"80\" style=\"".$colaccount."\">".$paytotal." <a href=\"paylist.php?memberid=".$memberid."\"><img src=\"images/arrowright.gif\" alt=\"".$strAccList."\" width=\"16\" height=\"16\" border=\"0\" /></a></td>

            <td width=\"80\" style=\"".$colaccount."\">".$buytotal." <a href=\"buylist.php?memberid=".$memberid."\"><img src=\"images/arrowright.gif\" alt=\"".$strAccBuyList."\" width=\"16\" height=\"16\" border=\"0\" /></a></td>

            <td width=\"65\" style=\"".$colcommon."\">".$regtime."</td>

            <td width=\"32\" align=\"center\"  style=\"".$colcommon."\">";

		showyn( $rz );

		echo "</td>

            <td  width=\"32\" align=\"center\" style=\"".$colcommon."\"><img id=\"membermail_".$memberid."\" class=\"membermail\" src=\"images/mail.png\"  border=\"0\" /></td>

            <td align=\"center\"  width=\"32\" style=\"".$colaccount."\"><a href=\"addacc.php?memberid=".$memberid."\"><img src=\"images/mail.png\"  border=\"0\" /></a></td>

            <td  width=\"32\" align=\"center\" style=\"".$colcent."\"><img id=\"membercent_".$memberid."\" class=\"membercent\" src=\"images/look.png\"  border=\"0\" /> </td>

            <td align=\"center\"  width=\"32\" style=\"".$colcommon."\"><img id=\"membermodify_".$memberid."\" class=\"membermodify\" src=\"images/edit.png\"  border=\"0\" /></td>

             <td align=\"center\"  width=\"32\" style=\"".$colaccount."\"><img id=\"membermodify_".$memberid."\" class=\"membermodify\" src=\"images/edit.png\"  border=\"0\" /></td>

           <td  width=\"32\" align=\"center\" style=\"".$colcommon."\"><a href=\"member_rights.php?memberid=".$memberid."&amp;nowtype=".$membertypeid."&amp;user=".$user."&amp;page=".$page."\"><img src=\"images/auth.png\"  border=\"0\" /></a></td>

            <td  width=\"32\" align=\"center\"><img src=\"images/person.png\" border=\"0\" style=\"cursor:pointer\" onClick=\"window.open('vmember.php?memberid=".$memberid."&tourl=member/index.php','vmember','width=1024,height=700,scrollbars=yes')\"></td>

          </tr>

          ";
    

}
    $total -= 10;
?>

</table>

</div>

<div class="piliang"> 

<input type="checkbox" name="SELALL" value="1" onClick="SelAll(this.form)"> <?php echo $strSelAll; ?>

<input type="radio" name="step" value="delall"> <?php echo $strDelete; ?>

<input type="radio" name="step" value="rzall" /> <?php echo $strMemberRzStat; ?>

<input type="radio" name="step" value="unrzall" /> <?php echo $strMemberUnRz; ?>

<input type="radio" name="step" value="chtypeall"> <?php echo $strMemberChangeTo; ?>		

<select name="newtypeid" >                

<?php

$fsql->query( "select * from {P}_member_type  order by membertypeid" );

while ( $fsql->next_record( ) )

{

		$changetypeid = $fsql->f( "membertypeid" );

		$changetype = $fsql->f( "membertype" );

		if ( $changetypeid == $membertypeid )

		{

				echo "<option value='".$changetypeid."' selected>".$changetype."</option>";

		}

		else

		{

				echo "<option value='".$changetypeid."'>".$changetype."</option>";

		}

}

?>

    </select>

       <input type="radio" name="step" value="addblack">

        <?php echo $strAddblack; ?> <input type="text" class="input" name="notice" value="">

    

        <input type="submit" name="Submit2" class="button" value="<?php echo $strSubmit; ?>" />

        &nbsp;&nbsp;<a style="cursor:pointer;color:#ffffff;font-weight:bold" onClick="delfm.submit()"> 

        </a> 

        <input type="hidden" name="ord" size="3" value="<?php echo $ord; ?>" />

        <input type="hidden" name="sc" size="3" value="<?php echo $sc; ?>" />

		<input type="hidden" name="membertypeid" size="3" value="<?php echo $membertypeid; ?>" />

		<input type="hidden" name="memberid" size="3" value="<?php echo $memberid; ?>" />

		<input type="hidden" name="key" size="3" value="<?php echo $key; ?>" />

        <input type="hidden" name="shownum" value="<?php echo $shownum; ?>" />

        <input type="hidden" name="showcheck" value="<?php echo $showcheck; ?>" />

		<input type="hidden" name="showrz" value="<?php echo $showrz; ?>" />

        <input type="hidden" name="searchmd" value="<?php echo $searchmd; ?>" />

        <span style="<?php echo $colaccount;?>">[目前會員帳戶餘額總計：<?php echo number_format($allaccount); ?> 元 ]</span>

</div>



</form>

<?php $pagesinfo = $pages->shownow( ); ?>

<div id="showpages">

	  <div id="pagesinfo"><?php echo $strPagesTotalStart.$totalnums.$strPagesTotalEnd; ?> <?php echo $strPagesMeiye.$pagesinfo['shownum'].$strPagesTotalEnd; ?> <?php echo $strPagesYeci; ?> <?php echo $pagesinfo['now']."/".$pagesinfo['total']; ?></div>

	  <div id="pages"><?php echo $pages->output( 1 ); ?></div>

</div>

</body>

</html>
