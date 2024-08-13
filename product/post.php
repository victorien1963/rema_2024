<?php
define("ROOTPATH", "../");
include(ROOTPATH."includes/common.inc.php");
include("language/".$sLan.".php");
include("includes/product.inc.php");

$act = $_POST['act'];

switch($act){


	//發佈時讀取參數列
	case "proplist" :
		
		$catid=$_POST["catid"];
		$nowid=$_POST["nowid"];

		if($nowid!="" && $nowid!="0"){
			$msql->query("select * from {P}_product_con where  id='$nowid'");
			if($msql->next_record()){
				$prop1=$msql->f('prop1');
				$prop2=$msql->f('prop2');
				$prop3=$msql->f('prop3');
				$prop4=$msql->f('prop4');
				$prop5=$msql->f('prop5');
				$prop6=$msql->f('prop6');
				$prop7=$msql->f('prop7');
				$prop8=$msql->f('prop8');
				$prop9=$msql->f('prop9');
				$prop10=$msql->f('prop10');
				$prop11=$msql->f('prop11');
				$prop12=$msql->f('prop12');
				$prop13=$msql->f('prop13');
				$prop14=$msql->f('prop14');
				$prop15=$msql->f('prop15');
				$prop16=$msql->f('prop16');
			}
		}

		$str="<table width='100%'   border='0' align='center'  cellpadding='2' cellspacing='1' >";
		$i=1;
		$msql->query("select * from {P}_product_prop where catid='$catid' order by xuhao");
		while($msql->next_record()){
		$propname=$msql->f('propname');
		$pn="prop".$i;
			$str.="<tr>"; 
			  $str.="<td width='80' height='30' align='center' >".$propname."</td>";
			  $str.="<td height='30' >"; 
			  $str.="<input type='text' name='".$pn."' value='".$$pn."' class='input' style='width:399px;' />";
			  $str.="</td>";
			  $str.="</tr>";

		$i++;
		}
		$str.="</table>";
		
		echo $str;
		exit;

	break;


	//產品管理-增加分類
	case "addcat" :
	
		$newcat=htmlspecialchars($_POST["newcat"]);
		
		//權限
		SecureMember();
		$memberid=$_COOKIE["MEMBERID"];
		if(SecureFunc("187")==false){
			echo "0";
			exit;
		}
		
		$msql->query("select max(xuhao) from {P}_product_pcat where memberid='$memberid'");
		if($msql->next_record()){
			$newxuhao=$msql->f('max(xuhao)')+1;
		}

		$msql->query("insert into {P}_product_pcat set 
		`memberid`='$memberid',
		`pid`='0',
		`xuhao`='$newxuhao',
		`cat`='$newcat'
		");
		
		$catid=$msql->instid();
		
		$str="<tr class='list' id='tr_".$catid."'>
		<td width='50' align='center'>".$catid."</td><td>
		<input id='catxuhao_".$catid."' name='xuhao' type='text' class='input'  value='".$newxuhao."' size='3' />
		<input id='cat_".$catid."' name='cat' type='text' class='input'  value='".$newcat."' size='30' /></td><td>
		<span id='gcat_".$catid."' class='cat_del'>".$strDelete."</span>	
		<span id='gcat_".$catid."' class='cat_modify'>".$strModify."</span> 
		</td>
		</tr>";

		echo $str;
		exit;

	break;



	//產品管理-修改分類
	case "modicat" :
	
		$catid=htmlspecialchars($_POST["catid"]);
		$cat=htmlspecialchars($_POST["cat"]);
		$xuhao=htmlspecialchars($_POST["xuhao"]);
		
		//權限
		SecureMember();
		$memberid=$_COOKIE["MEMBERID"];
		if(SecureFunc("187")==false){
			echo $strNoRights;
			exit;
		}
		
		$msql->query("update {P}_product_pcat set cat='$cat',xuhao='$xuhao' where catid='$catid' and memberid='$memberid'");
		

		echo "OK";
		exit;

	break;


	//產品管理-刪除分類
	case "delcat" :
	
		$catid=htmlspecialchars($_POST["catid"]);
		
		//權限
		SecureMember();
		$memberid=$_COOKIE["MEMBERID"];
		if(SecureFunc("187")==false){
			echo $strNoRights;
			exit;
		}

		$msql->query("delete from {P}_product_pcat where catid='$catid' and memberid='$memberid'");
	
		echo "OK";
		exit;

	break;


	//發佈
	case "productfabu":
		
		SecureMember();
		$memberid=$_COOKIE["MEMBERID"];



		//jform是在iframe中實現的，需要給中文提示加上編碼
		$Meta="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";


		//權限
		
		if(SecureFunc("181")==false){
			echo $Meta.$strNoRights;
			exit;
		}

		//免審核權限
		if(SecureFunc("183")==true){
			$iffb=1;
		}else{
			$iffb=0;
		}


		$title=htmlspecialchars($_POST["title"]);
		$catid=htmlspecialchars($_POST["catid"]);
		$pcatid=htmlspecialchars($_POST["pcatid"]);
		$author=htmlspecialchars($_POST["author"]);
		$source=htmlspecialchars($_POST["source"]);
		$memo=htmlspecialchars($_POST["memo"]);
		$prop1=htmlspecialchars($_POST["prop1"]);
		$prop2=htmlspecialchars($_POST["prop2"]);
		$prop3=htmlspecialchars($_POST["prop3"]);
		$prop4=htmlspecialchars($_POST["prop4"]);
		$prop5=htmlspecialchars($_POST["prop5"]);
		$prop6=htmlspecialchars($_POST["prop6"]);
		$prop7=htmlspecialchars($_POST["prop7"]);
		$prop8=htmlspecialchars($_POST["prop8"]);
		$prop9=htmlspecialchars($_POST["prop9"]);
		$prop10=htmlspecialchars($_POST["prop10"]);
		$prop11=htmlspecialchars($_POST["prop11"]);
		$prop12=htmlspecialchars($_POST["prop12"]);
		$prop13=htmlspecialchars($_POST["prop13"]);
		$prop14=htmlspecialchars($_POST["prop14"]);
		$prop15=htmlspecialchars($_POST["prop15"]);
		$prop16=htmlspecialchars($_POST["prop16"]);
		$prop17=htmlspecialchars($_POST["prop17"]);
		$prop18=htmlspecialchars($_POST["prop18"]);
		$prop19=htmlspecialchars($_POST["prop19"]);
		$prop20=htmlspecialchars($_POST["prop20"]);
		$tags=$_POST["tags"];
		$spe_selec=$_POST["spe_selec"];
		$pic=$_FILES["jpg"];

		$body=$_POST["body"];
		$body=Url2Path($body);

		//分類path
		$msql->query("select catpath from {P}_product_cat where catid='$catid'");
		if($msql->next_record()){
			$catpath=$msql->f('catpath');
		}

		$catArr=explode(":",$catpath);
		$bigcatid=intval($catArr[0]);

		//公共分類發佈授權校驗
		$secureset=SecureClass("186");
		if($_POST["catid"]!="0" && !strstr($secureset,":".$bigcatid.":")){
			echo $Meta.$strNoRights;
			exit;
		}

		
		//校驗處理

		if($title==""){
			echo $Meta.$strProductNTC1;
			exit;
		}
		if(strlen($title)>200){
			echo $Meta.$strProductNTC2;
			exit;
		}

		
		if(strlen($body)>65000){
			echo $Meta.$strProductNTC3;
			exit;
		}
		
		

		//圖片上傳
		if($pic["size"]>0){
			$nowdate=date("Ymd",time());
			$picpath=ROOTPATH."product/pics/".$nowdate;
			@mkdir($picpath,0777);
			$updir="product/pics/".$nowdate;
			$arr=ProductUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$updir);
			if($arr[0]!="err"){
				$src=$arr[3];
			}else{
				echo $Meta.$arr[1];
				exit;
			}
		}else{
			$src="";
		}


		//標籤處理
		for($t=0;$t<sizeof($tags);$t++){
			if($tags[$t]!=""){
				$tagstr.=$tags[$t].",";
			}
		}

		//專題分類
		$count_pro = count ($spe_selec);
		for ($i = 0; $i < $count_pro; $i ++) {
			$projid = $spe_selec[$i];
			$projpath .= $projid.":";
		}

		$dtime=time();

		
		
		$msql->query("insert into {P}_product_con set
		catid='$catid',
		catpath='$catpath',
		pcatid='$pcatid',
		title='$title',
		body='$body',
		dtime='$dtime',
		xuhao='0',
		cl='0',
		tj='0',
		iffb='$iffb',
		ifbold='0',
		ifred='',
		`type`='',
		src='$src',
		uptime='$dtime',
		author='$author',
		source='$source',
		memberid='$memberid',
		proj='$projpath',
		tags='$tagstr',
		secure='0',
		prop1='$prop1',
		prop2='$prop2',
		prop3='$prop3',
		prop4='$prop4',
		prop5='$prop5',
		prop6='$prop6',
		prop7='$prop7',
		prop8='$prop8',
		prop9='$prop9',
		prop10='$prop10',
		prop11='$prop11',
		prop12='$prop12',
		prop13='$prop13',
		prop14='$prop14',
		prop15='$prop15',
		prop16='$prop16',
		prop17='$prop17',
		prop18='$prop18',
		prop19='$prop19',
		prop20='$prop20',
		memo='$memo'
		");

		$id=$msql->instid();

		//積分計算
		MemberCentUpdate($memberid,"181");

		echo "OK";
		exit;

	break;





	//修改
	case "productmodify":
		
		SecureMember();
		$memberid=$_COOKIE["MEMBERID"];

		//jform是在iframe中實現的，需要給中文提示加上編碼
		$Meta="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";


		//權限
		if(SecureFunc("182")==false){
			echo $Meta.$strNoRights;
			exit;
		}

		//免審核權限
		if(SecureFunc("183")==true){
			$iffb=1;
		}else{
			$iffb=0;
		}




		$id=$_POST["id"];
		$title=htmlspecialchars($_POST["title"]);
		$catid=htmlspecialchars($_POST["catid"]);
		$pcatid=htmlspecialchars($_POST["pcatid"]);
		$author=htmlspecialchars($_POST["author"]);
		$source=htmlspecialchars($_POST["source"]);
		$memo=htmlspecialchars($_POST["memo"]);
		$prop1=htmlspecialchars($_POST["prop1"]);
		$prop2=htmlspecialchars($_POST["prop2"]);
		$prop3=htmlspecialchars($_POST["prop3"]);
		$prop4=htmlspecialchars($_POST["prop4"]);
		$prop5=htmlspecialchars($_POST["prop5"]);
		$prop6=htmlspecialchars($_POST["prop6"]);
		$prop7=htmlspecialchars($_POST["prop7"]);
		$prop8=htmlspecialchars($_POST["prop8"]);
		$prop9=htmlspecialchars($_POST["prop9"]);
		$prop10=htmlspecialchars($_POST["prop10"]);
		$prop11=htmlspecialchars($_POST["prop11"]);
		$prop12=htmlspecialchars($_POST["prop12"]);
		$prop13=htmlspecialchars($_POST["prop13"]);
		$prop14=htmlspecialchars($_POST["prop14"]);
		$prop15=htmlspecialchars($_POST["prop15"]);
		$prop16=htmlspecialchars($_POST["prop16"]);
		$prop17=htmlspecialchars($_POST["prop17"]);
		$prop18=htmlspecialchars($_POST["prop18"]);
		$prop19=htmlspecialchars($_POST["prop19"]);
		$prop20=htmlspecialchars($_POST["prop20"]);
		$tags=$_POST["tags"];
		$spe_selec=$_POST["spe_selec"];
		$pic=$_FILES["jpg"];

		$body=$_POST["body"];
		$body=Url2Path($body);


		//分類path
		$msql->query("select catpath from {P}_product_cat where catid='$catid'");
		if($msql->next_record()){
			$catpath=$msql->f('catpath');
		}

		$catArr=explode(":",$catpath);
		$bigcatid=intval($catArr[0]);

		//公共分類發佈授權校驗
		$secureset=SecureClass("186");
		if($_POST["catid"]!="0" && !strstr($secureset,":".$bigcatid.":")){
			echo $Meta.$strNoRights;
			exit;
		}

		if($title==""){
			echo $Meta.$strProductNTC1;
			exit;
		}
		if(strlen($title)>200){
			echo $Meta.$strProductNTC2;
			exit;
		}
		
		if(strlen($body)>65000){
			echo $Meta.$strProductNTC3;
			exit;
		}


		//圖片上傳
		if($pic["size"]>0){
			$nowdate=date("Ymd",time());
			$picpath=ROOTPATH."product/pics/".$nowdate;
			@mkdir($picpath,0777);
			$updir="product/pics/".$nowdate;

			$arr=ProductUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$updir);
			if($arr[0]!="err"){
				$src=$arr[3];
				
				//刪除原圖
				$msql->query("select src from {P}_product_con where memberid='$memberid' and id='$id'");
				if($msql->next_record()){
					$oldsrc=$msql->f('src');
				}
				if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!="" && !strstr($oldsrc,"../")){
					unlink(ROOTPATH.$oldsrc);
				}

				//更新記錄
				$msql->query("update {P}_product_con set src='$src' where memberid='$memberid' and id='$id'");
			
			}else{
				echo $Meta.$arr[1];
				exit;
			}
		}



		//標籤處理
		for($t=0;$t<sizeof($tags);$t++){
			if($tags[$t]!=""){
				$tagstr.=$tags[$t].",";
			}
		}

		//專題分類
		$count_pro = count ($spe_selec);
		for ($i = 0; $i < $count_pro; $i ++) {
			$projid = $spe_selec[$i];
			$projpath .= $projid.":";
		}

		$dtime=time();

		$msql->query("update {P}_product_con set 
		catid='$catid',
		catpath='$catpath',
		pcatid='$pcatid',
		title='$title',
		body='$body',
		uptime='$dtime',
		iffb='$iffb',
		tags='$tagstr',
		author='$author',
		source='$source',
		proj='$projpath',
		prop1='$prop1',
		prop2='$prop2',
		prop3='$prop3',
		prop4='$prop4',
		prop5='$prop5',
		prop6='$prop6',
		prop7='$prop7',
		prop8='$prop8',
		prop9='$prop9',
		prop10='$prop10',
		prop11='$prop11',
		prop12='$prop12',
		prop13='$prop13',
		prop14='$prop14',
		prop15='$prop15',
		prop16='$prop16',
		prop17='$prop17',
		prop18='$prop18',
		prop19='$prop19',
		prop20='$prop20',
		memo='$memo'

		where memberid='$memberid' and id='$id'");


		echo "OK";
		exit;

	break;

	
	//增加內容翻頁
	case "addpage" :
		
		$nowid=$_POST["nowid"];

		//權限
		SecureMember();
		$memberid=$_COOKIE["MEMBERID"];
		if(SecureFunc("182")==false){
			echo $strNoRights;
			exit;
		}


		//主記錄屬主符合校驗
		$msql->query("select id from {P}_product_con where id='$nowid' and memberid='$memberid'");
		if($msql->next_record()){
		}else{
			echo $strNoRights;
			exit;
		}

		$xuhao=0;
		if($nowid!="" && $nowid!="0"){
			$msql->query("select max(xuhao) from {P}_product_pages where productid='$nowid'");
			if($msql->next_record()){
				$xuhao=$msql->f('max(xuhao)');
			}
			$xuhao=$xuhao+1;
			$msql->query("insert into {P}_product_pages set productid='$nowid',xuhao='$xuhao' ");
		}
		echo "OK";
		exit;

	break;

	
	//內容翻頁顯示
	case "productpageslist" :
		
		$nowid=$_POST["nowid"];
		$pageinit=$_POST["pageinit"];

		$str="<ul>";
		$str.="<li id='p_0' class='pages'>1</li>";

		$i=2;
		$id=0;
		$msql->query("select id from {P}_product_pages where productid='$nowid' order by xuhao");
		while($msql->next_record()){
			$id=$msql->f('id');
			$str.="<li id='p_".$id."' class='pages'>".$i."</li>";
			$i++;
		}
		
		//判斷新增狀態
		if($pageinit!="new"){
			$id=$pageinit;
		}

		$str.="<li id='addpage' class='addbutton'>".$strProductPagesAdd."</li>";
		if($pageinit!="0"){
			$str.="<li id='pagedelete' class='addbutton'>".$strProductPagesDel."</li>";
			$str.="<li id='backtomodi' class='addbutton'>".$strBack."</li>";
		}
		
		$str.="</ul><input id='productpagesid' name='productpagesid' type='hidden' value='".$id."'>";
		echo $str;
		exit;

	break;


	//會員管理獲取組圖
	case "getimg" :
		
		$nowid=$_POST["nowid"];
		$productpageid=$_POST["productpageid"];

		if($productpageid=="-1"){

			$src="";

		}elseif($productpageid=="0"){
			
			$msql->query("select src from {P}_product_con where id='$nowid'");
			if($msql->next_record()){
				$src=$msql->f('src');
			}

		}else{

			$msql->query("select src from {P}_product_pages where id='$productpageid'");
			if($msql->next_record()){
				$src=$msql->f('src');
			}else{
				$src="";
			}

		}

		echo $src;
		exit;

	break;	



	//刪除一個分頁
	case "pagedelete" :

		$delpagesid=$_POST["delpagesid"];
		$nowid=$_POST["nowid"];

		//權限
		SecureMember();
		$memberid=$_COOKIE["MEMBERID"];
		if(SecureFunc("182")==false){
			echo "NORIGHTS";
			exit;
		}

		//主記錄屬主符合校驗
		$msql->query("select id from {P}_product_con where id='$nowid' and memberid='$memberid'");
		if($msql->next_record()){
		}else{
			echo "NORIGHTS";
			exit;
		}

		
		$i=0;
		$msql->query("select id from {P}_product_pages where productid='$nowid' order by xuhao");
		while($msql->next_record()){
			$id[$i]=$msql->f('id');
			if($id[$i]==$delpagesid){
				if($i==0){
					$lastid=0;
				}else{
					$lastid=$id[$i-1];
				}
				
			}
			$i++;
		}

		if($lastid==0 && $i>1){
			$lastid=$id[1];
		}


		//刪除圖片 
		$msql->query("select src from {P}_product_pages where id='$delpagesid'");
		if($msql->next_record()){
			$oldsrc=$msql->f('src');
			if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!="" && !strstr($oldsrc,"../")){
				unlink(ROOTPATH.$oldsrc);
			}
		}

		

		//更新資料
		$msql->query("delete from  {P}_product_pages where id='$delpagesid'");
		
		echo $lastid;
		exit;

	break;




	
	//上傳組圖
	case "contentmodify" :

		$productpagesid=$_POST["productpagesid"];
		$pic=$_FILES["jpg"];
		$id=$_POST["id"];

		$Meta="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";


		//權限
		SecureMember();
		$memberid=$_COOKIE["MEMBERID"];
		
		if(SecureFunc("182")==false){
			echo $Meta.$strNoRights;
			exit;
		}
		
		if(SecureFunc("183")==true){
			$iffb=1;
		}else{
			$iffb=0;
		}


		//主記錄屬主符合校驗
		$msql->query("select id from {P}_product_con where id='$id' and memberid='$memberid'");
		if($msql->next_record()){
		}else{
			echo $Meta.$strNoRights;
			exit;
		}



		//校驗處理
		if($pic["size"]<=0){
			echo $Meta.$strProductNTC5;
			exit;
		}

		//更新圖片
		if($pic["size"]>0){
			$nowdate=date("Ymd",time());
			$picpath=ROOTPATH."product/pics/".$nowdate;
			@mkdir($picpath,0777);
			$uppath="product/pics/".$nowdate;
			
			$arr=ProductUploadImage($pic["tmp_name"],$pic["type"],$pic["size"],$uppath);
			if($arr[0]!="err"){
				$src=$arr[3];
			}else{
				echo $Meta.$arr[1];
				exit;
			}

			$msql->query("select src from {P}_product_pages where id='$productpagesid'");
			if($msql->next_record()){
				$oldsrc=$msql->f('src');
			}
			if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!="" && !strstr($oldsrc,"../")){
				unlink(ROOTPATH.$oldsrc);
			}

			$msql->query("update {P}_product_pages set src='$src' where id='$productpagesid'");
			$msql->query("update {P}_product_con set iffb='$iffb' where id='$id'");

		}


		echo "OK";
		exit;

	break;




	//詳情翻頁
	case "contentpages" :

		$productid=$_POST["productid"];
		
		$str="<li id='p_0' class='pages'>1</li>";

		$i=2;
		$id=0;
		$msql->query("select id from {P}_product_pages where productid='$productid' order by xuhao");
		while($msql->next_record()){
			$id=$msql->f('id');
			$str.="<li id='p_".$id."' class='pages'>".$i."</li>";
			$i++;
		}
		
		echo $str;
		exit;
	
	
	break;




	//獲取組圖
	case "getcontent" :
		
		$productid=$_POST["productid"];
		$productpageid=$_POST["productpageid"];
		$RP=$_POST["RP"];

		if($productpageid=="0"){
			
			$msql->query("select src from {P}_product_con where id='$productid'");
			if($msql->next_record()){
				$src=$msql->f('src');
			}

		}else{

			$msql->query("select src from {P}_product_pages where id='$productpageid'");
			if($msql->next_record()){
				$src=$msql->f('src');
			}

		}

		echo $src;
		exit;

	break;	


	


	//評論後獲取最新一條
	case "getnewcomment" :
	
		$rid=$_POST["rid"];
		$RP=$_POST["RP"];
		
		$fsql->query("select * from {P}_comment where iffb='1' and catid='4' and pid='0' and rid='$rid' order by dtime desc limit 0,1");
		if($fsql->next_record()){
			$id=$fsql->f('id');
			$memberid=$fsql->f('memberid');
			$title=$fsql->f('title');
			$body=$fsql->f('body');
			$dtime=$fsql->f('dtime');
			$uptime=$fsql->f('uptime');
			$cl=$fsql->f('cl');
			$lastname=$fsql->f('lastname');
			$pj1=$fsql->f('pj1');

			$count=0;

			$body=strip_tags($body);


			//是否匿名

			if($memberid=="-1"){
				$pname=$strGuest;
				$nowface="1";
				$memberurl="#";
			}else{
				$tsql->query("select * from {P}_member where memberid='$memberid'");
				if($tsql->next_record()){
					$pname=$tsql->f("pname");
					$nowface=$tsql->f("nowface");
				}
				$memberurl=$RP."member/home.php?mid=".$memberid;
			}

					
			$dtime=date("Y-m-d",$dtime);
			$title=csubstr($title,0,20);
			$body=csubstr($body,0,120)." ...";

			$link=$RP."comment/html/?".$id.".html";
			$face=$RP."member/face/".$nowface.".gif";
			$pjstr=pstarnums($pj1,$RP);

			$var=array (
			'title' => $title, 
			'dtime' => $dtime, 
			'pname' => $pname, 
			'body' => $body, 
			'count' => $count, 
			'cl' => $cl, 
			'link' => $link,
			'memberurl' => $memberurl, 
			'lastname' => $lastname,
			'face' => $face, 
			'pjstr' => $pjstr, 
			'target' => $target
			);
			
			//模版解釋
			$Temp=LoadCommonTemp("tpl_product_comment.htm");
			$TempArr=SplitTblTemp($Temp);
			$str=ShowTplTemp($TempArr["list"],$var);
		}
		
		echo $str;
		exit;

	break;	


	//支持投票
	case "zhichi" :
	
		$productid=$_POST["productid"];
		
		if(!isLogin()){
			echo "L0";
			exit;
		}
		
		$memberid=$_COOKIE["MEMBERID"];
		$mstr="|".$memberid."|";
		$msql->query("select tplog,zhichi,memberid from {P}_product_con where id='$productid'");
		if($msql->next_record()){
			$tplog=$msql->f('tplog');
			$zhichi=$msql->f('zhichi');
			$mid=$msql->f('memberid');
		}
		if(strstr($tplog,$mstr)){
			echo "L1";
			exit;
		}else{
			$tplog=$tplog.$mstr;
		}

		$msql->query("update {P}_product_con set zhichi=zhichi+1,tplog='$tplog' where id='$productid'");

		//被支持者積分計算
		MemberCentUpdate($mid,"182");
		
		$num=$zhichi+1;
		echo $num;
		exit;

	break;	




	//反對投票
	case "fandui" :
	
		$productid=$_POST["productid"];
		
		if(!isLogin()){
			echo "L0";
			exit;
		}
		
		$memberid=$_COOKIE["MEMBERID"];
		$mstr="|".$memberid."|";
		$msql->query("select tplog,fandui,memberid from {P}_product_con where id='$productid'");
		if($msql->next_record()){
			$tplog=$msql->f('tplog');
			$fandui=$msql->f('fandui');
			$mid=$msql->f('memberid');
		}
		if(strstr($tplog,$mstr)){
			echo "L1";
			exit;
		}else{
			$tplog=$tplog.$mstr;
		}

		$msql->query("update {P}_product_con set fandui=fandui+1,tplog='$tplog' where id='$productid'");

		//被反對者積分計算
		MemberCentUpdate($mid,"183");
		
		$num=$fandui+1;
		echo $num;
		exit;

	break;


	//加入收藏
	case "addfav" :
	
		$productid=$_POST["productid"];
		$url=$_POST["url"];
		
		if(!isLogin()){
			echo "L0";
			exit;
		}
		
		$memberid=$_COOKIE["MEMBERID"];
		
		$msql->query("select title from {P}_product_con where id='$productid'");
		if($msql->next_record()){
			$title=$msql->f('title');
		}

		$msql->query("select id from {P}_member_fav where url='$url' and memberid='$memberid'");
		if($msql->next_record()){
			echo "L1";
			exit;
		}

		$msql->query("insert into {P}_member_fav set title='$title',url='$url',memberid='$memberid'");
		
		echo "OK";
		exit;

	break;




	//判斷是否版主，決定是否顯示版主功能連結
	case "ifbanzhu" :
		
		$productid=$_POST["productid"];

		if(!isLogin()){
			echo "NO";
			exit;
		}


		$msql->query("select catpath from {P}_product_con where id='$productid'");
		if($msql->next_record()){
			$catpath=$msql->f('catpath');
		}
		$arr=explode(":",$catpath);
		$bigcatid=intval($arr[0]);


		//沒有分類的內容校驗個人專區版主權限
		if($bigcatid=="" || $bigcatid=="0"){
			$bigcatid="PERSON";
		}

		
		$secureset=SecureBanzhu("189");

		if(strstr($secureset,":".$bigcatid.":")){
			echo "YES";
			exit;
		}else{
			echo "NO";
			exit;
		}

	break;



	//版主推薦
	case "banzhutj" :

		$productid=$_POST["productid"];
		if(!isLogin()){
			echo $strNoRights;
			exit;
		}

		//權限校驗
		$msql->query("select catpath,tj,memberid from {P}_product_con where id='$productid'");
		if($msql->next_record()){
			$catpath=$msql->f('catpath');
			$tj=$msql->f('tj');
			$mid=$msql->f('memberid');
		}
		$arr=explode(":",$catpath);
		$bigcatid=intval($arr[0]);

		
		//沒有分類的內容校驗個人專區版主權限
		if($bigcatid=="" || $bigcatid=="0"){
			$bigcatid="PERSON";
		}

		
		$secureset=SecureBanzhu("189");

		if(!strstr($secureset,":".$bigcatid.":")){
			echo $strNoRights;
			exit;
		}

		//校驗是否已經推薦(防止重複加分)
		if($tj!="0"){
			echo $strProductNTC6;
			exit;
		}

		
		$msql->query("update {P}_product_con set tj='1' where id='$productid'");


		//積分計算
		MemberCentUpdate($mid,"184");

		echo "OK";
		exit;

	break;


	//版主刪除
	case "banzhudel" :

		$productid=$_POST["productid"];
		$koufen=$_POST["koufen"];

		if(!isLogin()){
			echo $strNoRights;
			exit;
		}

		//權限校驗
		$msql->query("select catpath,memberid from {P}_product_con where id='$productid'");
		if($msql->next_record()){
			$catpath=$msql->f('catpath');
			$mid=$msql->f('memberid');
		}
		$arr=explode(":",$catpath);
		$bigcatid=intval($arr[0]);

		
		//沒有分類的內容校驗個人專區版主權限
		if($bigcatid=="" || $bigcatid=="0"){
			$bigcatid="PERSON";
		}

		
		$secureset=SecureBanzhu("189");

		if(!strstr($secureset,":".$bigcatid.":")){
			echo $strNoRights;
			exit;
		}


		//刪除
		//刪除原圖
		$fsql->query("select src from {P}_product_con where id='$productid'");
		if($fsql->next_record()){
			$oldsrc=$fsql->f('src');
			if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!="" && !strstr($oldsrc,"../")){
				@unlink(ROOTPATH.$oldsrc);
			}
		}

		//刪除組圖
		$fsql->query("select src from {P}_product_pages where productid='$productid'");
		while($fsql->next_record()){
			$oldsrc=$fsql->f('src');
			if(file_exists(ROOTPATH.$oldsrc) && $oldsrc!="" && !strstr($oldsrc,"../")){
				@unlink(ROOTPATH.$oldsrc);
			}
		}

		
		//刪除分頁記錄
		$fsql->query("delete from {P}_product_pages where productid='$productid'");

		//刪除主記錄
		$fsql->query("delete from {P}_product_con where id='$productid'");

		
		//積分計算
		if($koufen=="yes"){
			MemberCentUpdate($mid,"185");
		}


		echo "OK";
		exit;

	break;

}
?>