<?php
/*
	[����W��] �����s�i
	[�A�νd��] ����
*/

function AdvsLb () { 
	global $msql;
	
	$coltitle = $GLOBALS['PLUSVARS']['coltitle'];
	$shownums = $GLOBALS['PLUSVARS']['shownums'];
	$tempname = $GLOBALS['PLUSVARS']['tempname'];
	$groupid = $GLOBALS['PLUSVARS']['groupid'];

	$Temp = loadtemp( $tempname );
	$TempArr = splittbltemp( $Temp );
	$var = array(
		"coltitle" => $coltitle
	);
	$str = showtpltemp( $TempArr['start'], $var );
	$msql->query( "select * from {P}_advs_lb  where groupid='{$groupid}' order by xuhao limit 0,{$shownums}" );
	$btn = 0;
	if($tempname === 'tpl_advslb_sw.htm') {
		$str = '';
		while ( $msql->next_record() ) {
			$id = $msql->f( "id" );
			$getlans = strTranslate("advs_lb", $id);
			$title=$getlans['title']? $getlans['title']:$msql->f( "title" );
			$memo=$getlans['memo']? $getlans['memo']:$msql->f( "memo" );
			$src = $getlans['src']? $getlans['src']:$msql->f( "src" );
			$src1 = $getlans['src1']? $getlans['src1']:$msql->f( "src1" );
			$url = $getlans['url']? $getlans['url']:$msql->f( "url" );
			$type_name = $getlans['type_name']? $getlans['type_name']:$msql->f( "type_name" );
			$type_link = $getlans['type_link']? $getlans['type_link']:$msql->f( "type_link" );
			$position = $getlans['position']? $getlans['position']:$msql->f( "position" );
			$header_color = $getlans['header_color']? $getlans['header_color']:$msql->f( "header_color" );
			list($title, $subtitle) = explode("-",$title);
			$src = ROOTPATH.$src;
			$src1 = ROOTPATH.$src1;
			$memolist = explode("-",$title);
			$var = [
				'title' => $title,
				'memo' => $memo,
				'src' => $src,
				'type_link' => $type_link,
				'type_name' => $type_name,
				'position' => $position,
				'header_color' => $header_color
			];
			$str .= showtpltemp( $TempArr['list'], $var );
		}
		
		$str = str_replace("{#slidelist#}", $start, $str);
		
	} else {

		
		
		while ( $msql->next_record( ) )
		{
			
						$id = $msql->f( "id" );
						$getlans = strTranslate("advs_lb", $id);
						$title=$getlans['title']? $getlans['title']:$msql->f( "title" );
						$memo=$getlans['memo']? $getlans['memo']:$msql->f( "memo" );
						$src = $getlans['src']? $getlans['src']:$msql->f( "src" );
						$src1 = $getlans['src1']? $getlans['src1']:$msql->f( "src1" );
						$url = $getlans['url']? $getlans['url']:$msql->f( "url" );
						list($title, $subtitle) = explode("-",$title);
						$src = ROOTPATH.$src;
						$src1 = ROOTPATH.$src1;
						$memolist = explode("-",$title);
						
						if($url){
							$youtube_url = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
							preg_match($youtube_url, $url, $matches);
							$matches = array_filter($matches, function($var) {
								return($var !== '');
							});
							if (sizeof($matches) == 2) {
								$YID = $matches[1];
								$url = "https://www.youtube.com/embed/".$YID."?rel=0&amp;amp;controls=0&amp;amp;showinfo=0&amp;amp;autoplay=1&amp;amp;enablejsapi=1&amp;amp;version=3&amp;amp;loop=1&amp;amp;playlist=".$YID;
								$mediapic = "https://img.youtube.com/vi/".$YID."/0.jpg";
								$showmedia = true;
							}else{
								$showmedia = false;
							}
							/*$youtube_url = "/https?:\/\/(?:www\.)?youtu(?:\.be|be\.com)\/watch(?:\?(.*?)&|\?)v=([a-zA-Z0-9_\-]+)(\S*)/i";
							if (preg_match($youtube_url, $url, $youtube)){
								$url = "https://www.youtube.com/embed/".$youtube[2]."?feature=oembed&amp;amp;wmode=opaque";
								$showmedia = true;
							}else{
								$showmedia = false;
							}*/
						}else{
							$showmedia = false;
						}
						
						$var = array(
										"src" => $src,
										"src1" => $src1,
										"btn" => $btn,
										"n" => $btn+1,
										"url" => $url=="http://"? "javascript:;":$url,
										/*"title" => $title,
										"subtitle" => $subtitle,
										"caption1" => $memolist[0],
										"caption2" => $memolist[1],*/
										"active" => $btn ==0? "active":"",
										"title" => $title,
										"memo" => $memo,
										"catLBid" => $catLBid,
										"catLBclass" => $catLBclass
						);				
						

						if($showmedia){
							$str .= showtpltemp( $TempArr['m1'], $var );
						}else{
							if($btn==2){
								$str .= showtpltemp( $TempArr['menu'], $var );
							}elseif($btn==1){
								$str .= showtpltemp( $TempArr['text'], $var );
							}else{
								$str .= showtpltemp( $TempArr['list'], $var );
							}
						}
						//$str .= showtpltemp( $TempArr['list'], $var );
						//$arrimg .= "image_array[$btn] = \"".$src1."\"\n";
						$slidelist .= showtpltemp( $TempArr['m0'], $var );
						$btn++;
		}


						/*$var = array(
								"arrayimg" => $arrimg
				);
				$str .= showtpltemp( $TempArr['menu'], $var );*/
				$str .= $TempArr['end'];
				$str = str_replace("{#slidelist#}", $slidelist, $str);

		
	}
	return $str;
}
				
				



?>