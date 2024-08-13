<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/comment.inc.php");

$act = $_POST['act'];

switch($act){


	//表單送出
	case "commentsend":
		
		$REMOTE_ADDR=$_SERVER["REMOTE_ADDR"];
	
		$title=htmlspecialchars($_POST["title"]);
		$useedit=htmlspecialchars($_POST["useedit"]);
		$star=htmlspecialchars($_POST["star"]);
		$catid=htmlspecialchars($_POST["catid"]);
		$rid=htmlspecialchars($_POST["rid"]);
		$pid=htmlspecialchars($_POST["pid"]);
		$pj1=htmlspecialchars($_POST["pj1"]);
		$pj2=htmlspecialchars($_POST["pj2"]);
		$pj3=htmlspecialchars($_POST["pj3"]);
		$nomember=htmlspecialchars($_POST["nomember"]);


		//兼容編輯器和非編輯器並存
		if($useedit=="1"){
			$body=Url2Path($_POST["body"]);
		}else{
			$body=htmlspecialchars($_POST["body"]);
			$body=nl2br($body);
		}
				
		$uptime=time();
		$dtime=time();
		
		//jform是在iframe中實現的，需要給中文提示加上編碼
		$Meta="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

		if(!isLogin() && $nomember!="1"){
			echo "NOTLOGIN";
			exit;
		}

		//校驗
		if($title==""){
			echo $Meta.$strCommentNTC1;
			exit;
		}

		if($body==""){
			echo $Meta.$strCommentNTC8;
			exit;
		}


		//關鍵詞過濾
		$DenyArr=explode(",",$GLOBALS["COMMENTCONF"]["KeywordDeny"]);
		for($i=0;$i<sizeof($DenyArr);$i++){
			if(strlen($DenyArr[$i])>2){
				if(strstr($body,$DenyArr[$i]) || strstr($title,$DenyArr[$i])){
					echo $strCommentNTC13;
					exit;
				}
			}
		}

		//標籤過濾
		$title=str_replace("{#","",$title);
		$title=str_replace("#}","",$title);
		$body=str_replace("{#","{ #",$body);
		$body=str_replace("#}","# }",$body);


		//圖形驗證
		$ImgCode=$_POST["ImgCode"];
		$Ic=$_COOKIE["CODEIMG"];
		$Ic=strrev($Ic)+5*2-9;
		$Ic=substr ($Ic,0,4);

		if($ImgCode=="" || $Ic!=$ImgCode){
			echo $Meta.$strIcErr;
			exit;
		}


		//是否匿名
		if($nomember=="1"){

			$memberid="-1";
			$pname=$strGuest;

			//匿名發表是否審核
			if($GLOBALS["COMMENTCONF"]["noMembercheck"]=="1"){
				$iffb=0;
			}else{
				$iffb=1;
			}


		}else{

			//獲取會員資訊
			$memberid=$_COOKIE["MEMBERID"];
			$pname=$_COOKIE["MEMBERPNAME"];

			//會員權限
			if($pid!="0" && $pid!="" ){
				if(SecureFunc("132")==false){
					echo $Meta.$strCommentNTC6;
					exit;
				}
			}else{
				if(SecureFunc("131")==false){
					echo $Meta.$strCommentNTC5;
					exit;
				}
			}


			//會員發佈是否審核
			if(SecureFunc("133")==true){
				$iffb=1;
			}else{
				$iffb=0;
			}
		}


		if($pid==""){
			$pid=0;
		}

		if($rid==""){
			$rid=0;
		}



		//評分-預留三檔評分，pj1-3兼容性處理，如果表單中沒有的評價，則以3分入庫
		if($pj1==""){$pj1=3;}
		if($pj2==""){$pj2=3;}
		if($pj3==""){$pj3=3;}
			
		
		//入庫

		$msql->query("insert into {P}_comment set
		   pid='$pid',
		   catid='$catid',
		   rid='$rid',
		   pname='$pname',
		   title='$title',
		   body='$body',
		   pj1='$pj1',
		   pj2='$pj2',
		   pj3='$pj3',
		   dtime='$dtime',
		   uptime='$uptime',
		   ip='$REMOTE_ADDR',
		   iffb='$iffb',
		   tuijian='0',
		   cl='0',
		   lastname='$pname',
		   lastmemberid='$memberid',
		   backcount='0',
		   xuhao='1',
		   memberid='$memberid'
		
		");

		$nowbbsid=$msql->instid();


		

		if($pid!="0" && $pid!="" ){

			//重新計算上級貼的回複數
			$msql->query("select count(id) from {P}_comment where pid='$pid' and iffb='1'");
			if($msql->next_record()){
				$backcount=$msql->f('count(id)');
			}
			
			//更新主記錄
			$msql->query("update {P}_comment set 
			uptime='$uptime',
			lastname='$pname',
			lastmemberid='$memberid',
			backcount='$backcount' 
			where id='$pid'");


			//回覆評論積分計算
			MemberCentUpdate($memberid,"132");

			
			//短信通知主貼發帖人
			$msql->query("select memberid from {P}_comment where id='$pid'");
			if($msql->next_record()){
				$tomemberid=$msql->f('memberid');
			}

			if($tomemberid!="0" && $tomemberid!="-1"){
				$msg=$pname.$strCommentNTC11."\n<a href=\"../comment/html/?".$pid.".html\">comment/html/?".$pid.".html</a>";
				$msql->query("insert into {P}_member_msn set
				`body`='$msg',
				`tomemberid`='$tomemberid',
				`frommemberid`='0',
				`dtime`='$dtime',
				`iflook`='0'
				");
			}


			//返回
			if($iffb=="1"){
				echo "OK_".$pid;
				exit;
			}else{
				echo "CHK";
				exit;
			}
			
		}else{
			
			//新評論積分計算
			MemberCentUpdate($memberid,"131");

			if($iffb=="1"){
				echo "OK_".$nowbbsid;
				exit;
			}else{
				echo "CHK";
				exit;
			}
		}
		
	break;



	//判斷是否版主，決定是否顯示版主功能連結
	case "ifbanzhu" :
		
		$commentid=$_POST["commentid"];

		if(!isLogin()){
			echo "NO";
			exit;
		}


		$msql->query("select catid from {P}_comment where id='$commentid'");
		if($msql->next_record()){
			$catid=$msql->f('catid');
		}
		
		$secureset=SecureBanzhu("139");

		if(strstr($secureset,":".$catid.":")){
			echo "YES";
			exit;
		}else{
			echo "NO";
			exit;
		}

	break;


	//版主推薦
	case "banzhutj" :

		$commentid=$_POST["commentid"];

		if(!isLogin()){
			echo $strNoRights;
			exit;
		}

		//權限校驗
		$msql->query("select catid,tuijian,memberid from {P}_comment where id='$commentid'");
		if($msql->next_record()){
			$catid=$msql->f('catid');
			$tuijian=$msql->f('tuijian');
			$mid=$msql->f('memberid');
		}

		
		$secureset=SecureBanzhu("139");

		if(!strstr($secureset,":".$catid.":")){
			echo $strNoRights;
			exit;
		}

		//校驗是否已經推薦(防止重複加分)
		if($tuijian!="0"){
			echo $strCommentNTC7;
			exit;
		}

		
		$msql->query("update {P}_comment set tuijian='1' where id='$commentid'");


		//積分計算
		MemberCentUpdate($mid,"134");

		echo "OK";
		exit;

	break;


	//版主刪除
	case "banzhudel" :

		$commentid=$_POST["commentid"];
		$koufen=$_POST["koufen"];

		if(!isLogin()){
			echo $strNoRights;
			exit;
		}

		//權限校驗
		$msql->query("select catid,memberid,pid from {P}_comment where id='$commentid'");
		if($msql->next_record()){
			$pid=$msql->f('pid');
			$catid=$msql->f('catid');
			$mid=$msql->f('memberid');
		}else{
			echo $strCommentNTC10;
			exit;
		}

		
		$secureset=SecureBanzhu("139");

		if(!strstr($secureset,":".$catid.":")){
			echo $strNoRights;
			exit;
		}

		//訪客不可扣分
		if($koufen=="yes" && $mid=="-1"){
			echo $strCommentNTC9;
			exit;
		}


		//對於主記錄,刪除回復記錄
		if($pid=="0" && $commentid!="0"){
			$fsql->query("delete from {P}_comment where pid='$commentid'");
		}

		//對於子記錄,減少主記錄回復計數
		if($pid!="0"){
			$fsql->query("update {P}_comment set backcount=backcount-1 where id='$pid'");
		}

		//刪除記錄
		$fsql->query("delete from {P}_comment where id='$commentid'");

		
		//積分計算
		if($koufen=="yes"){
			MemberCentUpdate($mid,"135");
		}


		echo "OK";
		exit;

	break;


}
?>