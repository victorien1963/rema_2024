<?php
//�Ĥ@�Ӧr���j�g
�ҲզW��Config();

//�ҲհѼƳ]�m
function �ҲզW��Config(){

	global $msql;

	$msql->query("select * from {P}_�ҲզW��_config");
	while($msql->next_record()){
	
	$variable=$msql->f('variable');
	$value=$msql->f('value');
	$GLOBALS["�ҲզW�٤j�gCONF"][$variable]=$value;
	}

}

?>