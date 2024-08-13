<?php
	
function countyunfeip( $w, $p, $dgs, $getrate="" )
{
		
		$yunfei = 0;
		$arr = explode( "|", $dgs );
		$m1 = $arr[0];
		if($getrate!=""){
			$m1 = round($m1/$getrate);
		}
		$m2 = $arr[1];
		if($getrate!=""){
			$m2 = round($m2/$getrate);
		}
		$m3 = $arr[2];
		$n1 = $arr[3];
		if($getrate!=""){
			$n1 = round($n1/$getrate);
		}
		$n2 = $arr[4];
		if($getrate!=""){
			$n2 = round($n2/$getrate);
		}
		$n3 = $arr[5];
		$p1 = $arr[6];
		if($getrate!=""){
			$p1 = round($p1/$getrate);
		}
		$p2 = $arr[7];
		if($getrate!=""){
			$p2 = round($p2/$getrate);
		}
		$p3 = $arr[8];
		if ( $m1 != "" && ( $m2 != "" || $m3 != "" ) )
		{
				if ( $p <= $m1 )
				{
						if ( $m2 != "" )
						{
								$yunfei = $yunfei + $m2;
								return $yunfei;
						}
						else
						{
								$yunfei = $yunfei + $p * $m3 / 100;
								return $yunfei;
						}
				}
		}
		$priyunfei = $yunfei;
		if ( $n1 != "" && ( $n2 != "" || $n3 != "" ) )
		{
				if ( $n1 < $p )
				{
						if ( $n2 != "" )
						{
								$yunfei = $priyunfei + $n2;
						}
						else
						{
								$yunfei = $priyunfei + $p * $n3 / 100;
						}
				}
		}
		if ( $p1 != "" && ( $p2 != "" || $p3 != "" ) && $n1 < $p1 )
		{
				if ( $p1 < $p )
				{
						if ( $p2 != "" )
						{
								$yunfei = $priyunfei + $p2;
						}
						else
						{
								$yunfei = $priyunfei + $p * $p3 / 100;
						}
				}
		}
		return $yunfei;
}


function positemtuiorderfun( $orderid, $OrderNo )
{
		global $tsql,$wsql;
		
/*slob add 2016-12-31 產生POS訂單*/
require_once ROOTPATH.'/Classes/PHPExcel.php';
require_once ROOTPATH.'/Classes/PHPExcel/IOFactory.php';

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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);

//行號
$excel_line = 1;

//產生第一列
$objPHPExcel->getActiveSheet()->setCellValue("A{$excel_line}", "退貨日期");
$objPHPExcel->getActiveSheet()->setCellValue("B{$excel_line}", "客戶單號");
$objPHPExcel->getActiveSheet()->setCellValue("C{$excel_line}", "客戶代號");
$objPHPExcel->getActiveSheet()->setCellValue("D{$excel_line}", "產品代號");
$objPHPExcel->getActiveSheet()->setCellValue("E{$excel_line}", "數量");
$objPHPExcel->getActiveSheet()->setCellValue("F{$excel_line}", "單價");
$objPHPExcel->getActiveSheet()->setCellValue("G{$excel_line}", "金額");

		$tsql->query( "select * from {P}_shop_orderitems where orderid='$orderid' and itemtui='1'" );
		while ( $tsql->next_record( ) )
		{
			//$excel_line++;
			$xdtime = (date("Y",$tsql->f("dtime"))-1911).date("md",$tsql->f("dtime"));
			$xprice = (INT)$tsql->f("price");
			$xjine = (INT)$tsql->f("jine");
			$xnum = $tsql->f("nums");
			$xbn = $tsql->f("bn");
			list($xsize,$Xprice,$xspecid) = explode("^",$tsql->f("fz"));
			$gwtspec = $wsql->getone( "select posproid from {P}_shop_conspec where id='{$xspecid}'" );
	$xbn = explode("-",$gwtspec['posproid']);
	$posxbn = explode(",",$xbn[0]);
	
	if($xbn[1]){
		$xbsize = $xbn[1];
		$posn = count($posxbn);
		$cjine = round($xjine/$posn);
		$sump=0;
		for($h=0; $h<$posn; $h++){
			if($h==$posn-1){
				$cxjine[$h] = $xjine - $sump;
			}else{
				$cxjine[$h] = $cjine;
				$sump += $cjine;
			}
		}
		foreach($posxbn AS $kk=>$vv){
			$xbn = $vv.$xbsize;
			$excel_line++;
			//產生其他列
			$objPHPExcel->getActiveSheet()->setCellValue("A{$excel_line}", $xdtime);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("B{$excel_line}", (string) $OrderNo,PHPExcel_Cell_DataType::TYPE_STRING); 
			$objPHPExcel->getActiveSheet()->setCellValue("C{$excel_line}", "PUBLIC");
			$objPHPExcel->getActiveSheet()->setCellValue("D{$excel_line}", $xbn);
			$objPHPExcel->getActiveSheet()->setCellValue("E{$excel_line}", $xnum);
			//$objPHPExcel->getActiveSheet()->setCellValue("F{$excel_line}", $xprice);
			$objPHPExcel->getActiveSheet()->setCellValue("F{$excel_line}", $cxjine[$kk]);
			$objPHPExcel->getActiveSheet()->setCellValue("G{$excel_line}", $cxjine[$kk]);
		}
	}else{
		$excel_line++;
		$xbn = $gwtspec['posproid'];
		//產生其他列
		$objPHPExcel->getActiveSheet()->setCellValue("A{$excel_line}", $xdtime);
		$objPHPExcel->getActiveSheet()->setCellValueExplicit("B{$excel_line}", (string) $OrderNo,PHPExcel_Cell_DataType::TYPE_STRING); 
		$objPHPExcel->getActiveSheet()->setCellValue("C{$excel_line}", "PUBLIC");
		$objPHPExcel->getActiveSheet()->setCellValue("D{$excel_line}", $xbn);
		$objPHPExcel->getActiveSheet()->setCellValue("E{$excel_line}", $xnum);
		$objPHPExcel->getActiveSheet()->setCellValue("F{$excel_line}", $xprice);
		$objPHPExcel->getActiveSheet()->setCellValue("G{$excel_line}", $xjine);
	}
		}
			//產生Excel
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//20003格式
			$objWriter->save("ftplog_GT/GT".$OrderNo.".xls");

			$file_GT = "GT".$OrderNo.".xls";   ### 上傳的檔案
			$file_GR = "GR".$OrderNo.".xls";   ### 複製的檔案
				
			### 複製檔案
			copy("ftplog_GT/".$file_GT , "ftplog_GR/".$file_GR);

			### 檢測FTP
			if($GLOBALS['GLOBALS']['CONF']['ftpConnect'] == '1'){

				### FTP 上傳
				//$fpt = fopen("ftplog_GT/".$file_GT, 'r');
				$fpr = fopen("ftplog_GR/".$file_GR, 'r');

				### 連接的 FTP 伺服器是 localhost
				$conn_id = ftp_connect($GLOBALS['GLOBALS']['CONF'][ftpAddress]);
				 
				### 登入 FTP, 帳號是 USERNAME, 密碼是 PASSWORD
				$login_result = ftp_login($conn_id, $GLOBALS['GLOBALS']['CONF'][ftpAccount], $GLOBALS['GLOBALS']['CONF'][ftpPassword]);

				### 上傳
				//ftp_fput($conn_id, "ImportData/GT/".$file_GT, $fpt, FTP_BINARY);
				### 上傳
				if(ftp_fput($conn_id, "ImportData/GR/".$file_GR, $fpr, FTP_BINARY)){
					@unlink("ftplog_GT/GT".$OrderNo.".xls");
					@unlink("ftplog_GR/GR".$OrderNo.".xls");
				}
				 
				ftp_close($conn_id);
				fclose($fp);

				/*if($login_result){
					@unlink("ftplog_GT/GT".$OrderNo.".xls");
					@unlink("ftplog_GR/GR".$OrderNo.".xls");
				}*/
			}

}
?>