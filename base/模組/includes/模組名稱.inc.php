<?php
//第一個字母大寫
模組名稱Config();

//模組參數設置
function 模組名稱Config(){

	global $msql;

	$msql->query("select * from {P}_模組名稱_config");
	while($msql->next_record()){
	
	$variable=$msql->f('variable');
	$value=$msql->f('value');
	$GLOBALS["模組名稱大寫CONF"][$variable]=$value;
	}

}

?>