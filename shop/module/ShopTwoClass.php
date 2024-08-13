<?php



/*

	[元件名稱] 一、二級分類

	[適用範圍] 所有頁面

*/







function ShopTwoClass(){



		global $msql,$fsql,$tsql;



		$catid=$GLOBALS["PLUSVARS"]["catid"];

		$showtj=$GLOBALS["PLUSVARS"]["showtj"];

		$target=$GLOBALS["PLUSVARS"]["target"];

		$tempname=$GLOBALS["PLUSVARS"]["tempname"];

		$pagename=$GLOBALS["PLUSVARS"]["pagename"];

		$ism = substr($pagename,-1)=="m"? true:false;

		

		if($catid!=0 && $catid!=""){

			$scl=" pid='$catid' ";

		}else{

			$scl=" pid='0' ";

		}



		

		if($showtj!="" && $showtj!="0"){

			$scl.=" and tj='1' ";

			$subscl=" and tj='1' ";

		}







		//模版解釋

		$Temp=LoadTemp($tempname);

		$TempArr=SplitTblTemp($Temp);





		$str=$TempArr["start"];

		

		if(!$ism){

			$limit = "limit 0,4";

		}



			

		$msql->query("select * from {P}_shop_cat where $scl order by xuhao");
		
		while($msql->next_record()){

				$catid=$msql->f("catid");

				$getlans = strTranslate("shop_cat", $catid);

				$oricat = $msql->f('cat');

				$cat=$getlans['cat']? $getlans['cat']:$msql->f('cat');



				$sublinkstr="";

				$fsql->query("select * from {P}_shop_cat where pid='$catid' $subscl order by xuhao $limit");
				
				while($fsql->next_record()){

					$scatid=$fsql->f("catid");

					$getlans = strTranslate("shop_cat", $scatid);

					//$scat=$getlans['cat']? $getlans['cat']:$fsql->f('cat');

					$scat=$fsql->f('cat');

					//EN

					$getlans_en = strTranslate("shop_cat",$scatid,"cat","en");

					$scaten= $getlans_en['cat'];

					

					//$scat=$fsql->f("cat");

					$scatpath=$fsql->f("catpath");

					$sifchannel=$fsql->f('ifchannel');

					$src=$fsql->f('src');

					$src2=$fsql->f('src2')? $fsql->f('src2'):$src;

					

					if($sifchannel=="1"){

						$slink=ROOTPATH."shop/class/".$scatid."/";

					}else{

						if($GLOBALS["CONF"]["CatchOpen"]=="1" && file_exists(ROOTPATH."shop/class/".$scatid.".html")){

							//$slink=ROOTPATH."shop/class/".$scatid.".html";

							$slink=ROOTPATH."rshopclass".$scatid;

						}else{

							//$slink=ROOTPATH."shop/class/?".$scatid.".html";

							$slink=ROOTPATH."shopclass".$scatid;

						}

					}

					

					/*slob add*/

					$man = $catid=="1"? "man":"woman";

					

					if($src != ""){

						$substr[$scat][$cat]["a"] = str_replace(array("{#src#}","{#man#}"),array(ROOTPATH.$src,$man),$TempArr["list"]);

						$substr[$scat][$cat]["src"] = ROOTPATH.$src2;

					}
						$show = $catid=="1" ? '<span class="divider-v"></span>':"";

						$substr[$scat][$cat]["b"] = str_replace(array("{#slink#}","{#man#}","{#scat#}","{#show#}"),array($slink,$man,$cat,$show),$TempArr["menu"]);

						$substr[$scat][$cat]["sub"] = $scaten;

						

						if($man == "man"){

							$gander = "gander-word-bn-line";

						}else{

							$gander = "";

						}

						$substr[$scat][$cat]["c"] = str_replace(array("{#slink#}","{#man#}","{#scat#}","{#gander#}"),array($slink,$man,$cat,$gander),$TempArr["text"]);

						

				}



		

		}

		

		$n =1;

		$s =1;

		foreach($substr AS $key=>$value){

			$sublinkstr = $menu = $menu2 = "";

			foreach($value AS $keys=>$vs){

				if(!$sublinkstr){

					$sublinkstr .= $vs["a"];

				}

				

				$menu .= $vs["b"];

				$scaten = $vs["sub"];

				$menu2 .= $vs["c"];

				if($vs["src"] != ""){

					$src = $vs["src"];

				}else{

					$src = "";

				}

			}

						

			$var=array (

				'subcat' => $key, 

				'subcat_en' => $scaten, 

				'sublinkstr' => $sublinkstr, 

				'menu' => $menu, 

				'menu2' => $menu2, 

				'src' => $src

				);

			

			if($s>2){

				$str .= ShowTplTemp($TempArr["m1"],$var);

				$mobilestr .= ShowTplTemp($TempArr["m2"],$var);

				if($s==4){

					$s=0;

				}

			}else{

				$str .= ShowTplTemp($TempArr["m0"],$var);

				$mobilestr .= ShowTplTemp($TempArr["m2"],$var);

			}


			if($n%2==0){

				// $str .= '

				// </div>

				// <div class="rema-col f20 sf23 sports-category-select">';

				// $mobilestr .= '</div>

				// <div class="rema-col l12 sports-category-select">';

			}

			$n++;

			$s++;

		}

		

		//var_dump($substr);

		

        $str.=$TempArr["end"];

        

        $str=str_replace("{#mobilelist#}",$mobilestr,$str);

       

		return $str;



		

}





?>