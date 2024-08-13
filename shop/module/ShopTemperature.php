<?php

class ShopTemperature {

	public static $temperatureValue = null;
	public static $ambienceValue = null;

	private $temperatureList = [
		1 => [
			'title' => '-10°C ~ 0°C'
		],
		2 => [
			'title' => '0°C ~ 10°C'
		],
		3 => [
			'title' => '10°C ~ 20°C'
		],
		4 => [
			'title' => '> 30°C'
		]
	];

    private $ambienceList = [
		1 => [
			'title' => 'COLD 冬季',
			'name' => 'COLD'
		],
		2 => [
			'title' => 'RAIN 雨天',
			'name' => 'RAIN'
		],
		3 => [
			'title' => 'WIND 防風',
			'name' => 'WIND'
		],
		4 => [
			'title' => 'HOT 夏季',
			'name' => 'HOT'
		]
	];

    public function getTemperatureList() 
    {
        return $this->temperatureList;
    }

	public function getHtml($TempArr) 
    {
		$gsubstr = '';
		if($this->temperatureValue) {
			$data = $this->temperatureList[$this->temperatureValue];
			$gsubstr = str_replace("{#title#}",$data['title'],$TempArr);
			$gsubstr = str_replace("{#key#}",$this->temperatureValue,$gsubstr);
		}
		
		return $gsubstr;
	}

    public function getAmbienceList() 
    {
        return $this->ambienceList;
    }

	public function getAmbienceHtml($TempArr) 
	{
		$gsubstr = '';
		if($this->ambienceValue) {
			$list = $this->ambienceList;
			$listHtml = '';
			
			foreach($list as $key => $val) {
				if($key == $this->ambienceValue) {
					$listHtml .= "
						<li class=\"active\">
							<div class=\"indicator\"></div>
							<div class=\"des\">" . $val['name'] . "</div>
						</li>
					";
				} else {
					$listHtml .= "
						<li>
							<div class=\"indicator\"></div>
							<div class=\"des\">" . $val['name'] . "</div>
						</li>
					";
				}
				
			}
			$gsubstr = $TempArr;
			$gsubstr = str_replace("{#title#}",$list[$this->ambienceValue]['title'],$gsubstr);
			$gsubstr = str_replace("{#list#}",$listHtml,$gsubstr);
		}
		

		return $gsubstr;
	}
}


?>