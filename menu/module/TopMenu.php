<?php

/*
	[����W��] �����ɯ���
	[�A�νd��] ����

*/


function TopMenu(){
	
	global $msql,$SiteUrl,$lantype,$fsql,$sybtype;


	$coltitle=$GLOBALS["PLUSVARS"]["coltitle"];
	$groupid=$GLOBALS["PLUSVARS"]["groupid"];
	$shownums=$GLOBALS["PLUSVARS"]["shownums"];
	$tempname=$GLOBALS["PLUSVARS"]["tempname"];
	
		//����f���B�ײv
		if($sybtype){
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",$sybtype);
		}else{
			list($getsymbol,$getpricecode,$getrate,$getpoint,$getpriceid) = explode(",",getDefaultSyb());
		}
		$CARTSTR = $_COOKIE["SHOPCART"];
		$array=explode('#',$CARTSTR);
		$tnums=sizeof($array)-1;
		$tjine=0;
		$tacc=0;
		$kk=0;
		
		include_once( ROOTPATH."shop/includes/shop.inc.php" );
		for($t=0;$t<$tnums;$t++){
				$fff=explode('|',$array[$t]);
				$gid=$fff[0];
				$acc=$fff[1];
				$fz=$fff[2];
				
				list($size, $buyprice, $specid) = explode("^",$fz);

				$fsql->query("select * from {P}_shop_con where id='$gid'");
				if($fsql->next_record()){
					$price=$fsql->f('price');
					$price=getMemberPrice($gid,$price);
					//���ȧ�
					$price=$getrate!="1"? round(($price*$getrate),$getpoint):$price;
					$jine=$price*$acc;
					
					$items .= '
					        <!-- list -->
					            <li class="list"><a>
					                    <p>'.$fsql->f(bn).' '.$fsql->f(title).'('.$fsql->f(colorname).' '.$size.') x '.$acc.'</p>
					                    <p>'.$getsymbol.' '.number_format($jine, $getpoint).'</p>
					                </a></li>
					        <!-- END list -->
					';
				}
			$tjine=$tjine+$jine;
			$tacc=$tacc+$acc;
			$kk++;
		}
		$tjine=number_format($tjine, $getpoint);


	$Temp=LoadTemp($tempname);

	$TempArr=SplitTblTemp($Temp);

	
	$var=array (
		'coltitle' => $coltitle
	);

	$str=ShowTplTemp($TempArr["start"],$var);
	
	$msql->query("select * from {P}_menu where ifshow='1' and groupid='$groupid' order by xuhao limit 0,$shownums");
	while($msql->next_record()){
			$id=$msql->f('id');
			$getlans = strTranslate("menu", $id);
			$menu=$getlans['menu']? $getlans['menu']:$msql->f('menu');
			//$menu=$msql->f('menu');
			$linktype=$msql->f('linktype');
			$coltype=$msql->f('coltype');
			$folder=$msql->f('folder');
			$url=$msql->f('url');
			$target=$msql->f('target');
			$m_id=$msql->f('m_id');
			$m_class=$msql->f('m_class');
			
			
			switch($linktype){
			

			//1=�����s��
			case "1" :
				$menuurl=ROOTPATH.$folder;
			break;

			
			//2=�~���s��
			case "2" :
				$menuurl=$url;
			break;
			
			//3=�Ҳ�
			case "3" :
				$menuurl=$folder;
			break;


			
			//�s����Ҳ�
			default:
				
				
				if($coltype=="index"){
					
					//�����S���B�z
					if($GLOBALS["CONF"]["CatchOpen"]=="1"){
						$menuurl=ROOTPATH;
					}else{
						$menuurl=ROOTPATH."index.php";
					}

				}else{
					
					//���`�Ҳճs��
					if($GLOBALS["CONF"]["CatchOpen"]=="1"){
						$menuurl=ROOTPATH.$coltype."/";
					}else{
						$menuurl=ROOTPATH.$coltype."/index.php";
					}
				}
				

			break;

		
		}
		
	
			
		if($_GET['lan'] == $m_id){
			$m_class = "laug1";
		}elseif($lantype == "_".$m_id){
			$m_class = "laug1";
		}elseif($lantype =="" && $GLOBALS['GLOBALS']['CONF']['LANTYPE'] == $m_id ){
			$m_class = "laug1";
		}else{
			$m_class = "laug2";
		}

		
		$var=array (
			'menu' => $menu, 
			'menuurl' => $menuurl,
			'target' => $target,
			'm_id' => $m_id,
			'm_class' => $m_class,
			'thisurl' => $_SERVER['REQUEST_URI'],
			'pricesymbol' => $getsymbol,
			'items' => $items,
			'cartnum' => $tacc,
			'cartprice' => $tjine,
		);
		
		if(stripos($menuurl,"member") !== false){
			$str.=ShowTplTemp($TempArr["m0"],$var);
		}elseif(stripos($menuurl,"facebook") !== false){
			$str.=ShowTplTemp($TempArr["m2"],$var);
		}elseif(stripos($menuurl,"cart") !== false){
			$str.=ShowTplTemp($TempArr["m1"],$var);
		}else{
			$str.=ShowTplTemp($TempArr["menu"],$var);
		}

	}

	
	$str.=$TempArr["end"];

	return $str;
		
	

}

?>