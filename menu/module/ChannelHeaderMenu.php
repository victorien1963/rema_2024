<?php

/*
[����W��] �G�žɯ���
[�A�νd��] ����

 */

function ChannelHeaderMenu()
{

    global $msql, $fsql, $tsql;

    $groupid = $GLOBALS["PLUSVARS"]["groupid"];
    $tempname = $GLOBALS["PLUSVARS"]["tempname"];
    $tempcolor = $GLOBALS["PLUSVARS"]["tempcolor"];

    $Temp = LoadTemp($tempname);
    $TempArr = SplitTblTemp($Temp);

    $var = array(
        'tempcolor' => $tempcolor,
    );

    $str = '';
	$pcMenuItems = '';
	$menu1 = "";
    $menu2 = "";
    $menu3 = "";
    /*�h��y���ഫ $getlans['menu']? $getlans['menu']:*/

    $n = -1;
    $msql->querylan("select * from {P}_menu where ifshow='1' and groupid='$groupid' and pid='0' order by xuhao ");
    while ($msql->next_record()) {
        $id = $msql->f('id');
        $getlans = strTranslate("menu", $id);
        $menustr = $getlans['menu'] ? $getlans['menu'] : $msql->f('menu');
        
        list($menu, $menuclass) = explode("-", $menustr);
		
        if ($menuclass == "tec") {
            $menuclass = "man";
            $submenuclass = "tec-nav";
        } else {
            $submenuclass = "";
        }
        // if (!islogin() && $menuclass == "member") {
        //     continue;
        // }
        $linktype = $msql->f('linktype');
        $coltype = $msql->f('coltype');
        $folder = $msql->f('folder');
        $url = $msql->f('url');
        $target = $msql->f('target');

        $coltypeMenu = "";
        $mobileStr = "";
        $mobileMenu3Str = "";
        
        $linkbtn = false;
        
        switch ($linktype) {
            case "1":

                $menuurl = ROOTPATH . $folder;
                list($coltype) = explode("/", $folder);
                if ($coltype != "page") {
                    if (stripos($_SERVER['PHP_SELF'], $coltype)) {$active = true;} else { $active = false;}
                    if (substr($_SERVER['REQUEST_URI'], 1) == $folder && stripos($pagename, "detail") === false) {$active = true;} else { $active = false;}
                    if (stripos($pagename, "detail") !== false) {

                        if (strstr($_SERVER["QUERY_STRING"], ".html")) {
                            $Arr = explode(".html", $_SERVER["QUERY_STRING"]);
                            $nid = $Arr[0];
                            $getcat = $fsql->getone("select catpath from {P}_{$nowcoltype}_con where id='$nid'");
                            list($thiscatid) = explode(":", $getcat["catpath"]);
                            $thiscatid = (INT) $thiscatid;
                            if ("/" . $nowcoltype . "/class/?" . $thiscatid . ".html" == "/" . $folder) {$active = true;} else { $active = false;}
                        }
                    }
                    if ($nowcoltype == "shop" && stripos($folder, "shop/class") !== false) {$active = true;} else { $active = false;}

                    if (substr($_SERVER['REQUEST_URI'], 0, 6) == substr("/" . $folder, 0, 6)) {$active = true;}

                } else {
                    if ($_SERVER['PHP_SELF'] == "/" . $folder || $_SERVER['PHP_SELF'] == "/" . $folder . "/index.php") {$active = true;} else { $active = false;}
                }

                // $sMenuStr = MainMenu_s($id, $TempArr["list"]);

                $n++;
                $linkbtn = true;
                break;
            case "2":

                $menuurl = $url;
                
                //�G�ſ��
                list($coltypeMenu, $mobileStr, $mobileMenu3Str) = coltypeMenuMainMenu_s($id, "", $TempArr);
                $n++;
                
				$active = false;
                // $active = true;
                break;

            //3=�Ҳդ����s��
            case "3":

                $active = "";

                list($catcoltype, $catid) = explode(",", $folder);

                //$menuurl=ROOTPATH.$catcoltype."roj".$catid;
                $menuurl = "javascript:;";

                if ($_SERVER['REQUEST_URI'] == "/" . $catcoltype . "roj" . $catid) {
                    $active = true;
                } else {
                    if (stripos($_SERVER['REQUEST_URI'], "shopclass") !== false) {
                        //���Ʀr
                        $maybeclass = preg_replace('/\D/', '', $_SERVER['REQUEST_URI']);
                        //�P�_�D����ID
                        $getMainCatid = $tsql->getone("SELECT catpath FROM {P}_shop_cat WHERE catid='{$maybeclass}'");
                        list($getMain) = explode(":", $getMainCatid["catpath"]);
                        $getMain = 0 - $getMain;
                        $showcatid = 0 - $catid;
                        if ($getMain == $showcatid) {
                            $active = true;
                        }
                    } elseif (stripos($_SERVER['REQUEST_URI'], "shop") !== false) {
                        //���Ʀr
                        $maybeclass = preg_replace('/\D/', '', $_SERVER['REQUEST_URI']);
                        //�P�_�D����ID
                        $getMainCatid = $tsql->getone("SELECT catpath FROM {P}_shop_con WHERE id='{$maybeclass}'");
                        list($getMain) = explode(":", $getMainCatid["catpath"]);
                        $getMain = 0 - $getMain;
                        $showcatid = 0 - $catid;
                        if ($getMain == $showcatid) {
                            $active = true;
                        }
                    }
                }

                //�Ҳդ������
                list($coltypeMenu, $mobileStr, $mobileMenu3Str) = coltypeMenu($catcoltype, $catid, $TempArr);
                $pageMenu = "";
                if ($coltypeMenu && $catid == 1) {
                    $pageMenu = pageMenu(4);
                } elseif ($coltypeMenu && $catid == 2) {
                    $pageMenu = pageMenu(5);
                }

                //�G�ſ��
                // $sMenuStr = MainMenu_s($id, $TempArr["list"]);
                
                $n++;

                break;

            //4
            case "4":

                $active = "";

                list($catcoltype, $catid) = explode(",", $folder);

                //$menuurl=ROOTPATH.$catcoltype."roj".$catid;
                $menuurl = "#";

                //�Ҳդ������
                $coltypeMenu = coltypeMenu1($catcoltype, $catid, $TempArr["m0"]);
                $pageMenu = "";
                //$pageMenu=pageMenu(5);

                //�G�ſ��
                // $sMenuStr = MainMenu_s($id, $TempArr["list"]);
                $n++;

                break;

            //�s����Ҳ�
            default:
                
                if ($coltype == "index") {

                    //�����S���B�z
                    if ($GLOBALS["CONF"]["CatchOpen"] == "1") {
                        $menuurl = ROOTPATH;
                    } else {
                        $menuurl = ROOTPATH . "index.php";
                    }

                } else {

                    //���`�Ҳճs��
                    if ($GLOBALS["CONF"]["CatchOpen"] == "1") {
                        $menuurl = ROOTPATH . $coltype . "/";
                    } else {
                        $menuurl = ROOTPATH . $coltype . "/index.php";
                    }
                }

                //�G�ſ��
                $n++;

                break;

        }
        if ($GLOBALS["PSET"]["coltype"] == $coltype) {
            $m = $n;
        }

        if (
            strpos($_SERVER['REQUEST_URI'], 'story') ||  
            strpos($_SERVER['REQUEST_URI'], 'experience') ||
            strpos($_SERVER['REQUEST_URI'], 'green') ||
            strpos($_SERVER['REQUEST_URI'], 'life') ||
            strpos($_SERVER['REQUEST_URI'], 'Vision')
        ) {
            if($n === 2) {
                $active = true;
            } else {
                $active = false;
            }
        }  else {
            if(!stripos($_SERVER['REQUEST_URI'], "shop")) {
                if($n === 0) {
                    $active = true;
                } else {
                    $active = false;
                }
            }
        }

        if($menuclass === 'member') {
            if(!islogin()) {
                $menu = '登入/註冊';
            }
            
            $menuurl = 'javascript:;';
            $linkbtn = true;
            $active = '';
        }

        $var = array(
            'menu' => $menu,
            'n' => $n,
            'menuurl' => $menuurl,
            'target' => $target,
            'm1' => $coltypeMenu,
            'pagemenu' => $pageMenu,
            'menuclass' => $menuclass,
            'submenuclass' => $submenuclass,
            'active' => $active ? 'active' : '',
			'id' => $linkbtn ? '' : 'tag-' . $id,
            'm3' => $mobileStr
        );

		

        // if ($coltypeMenu != "" || $sMenuStr != "") {
        //     $str .= ShowTplTemp($TempArr["menu"], $var);
        // } else {
        //     $str .= ShowTplTemp($TempArr["m1"], $var);
        // }
        // file_put_contents("msg111.txt", print_r($TempArr, 1) . "\n", FILE_APPEND);
		$pcMenuItems .= ShowTplTemp($TempArr["m0"], $var);
		if ($coltypeMenu != "") {
            $menu1 .= ShowTplTemp($TempArr["menu1"], $var);
            $menu2 .= ShowTplTemp($TempArr["menu2"], $var);
            $menu3 .= ShowTplTemp($mobileMenu3Str, ['menuName' => $menu]);
        }
		
    }
    
    $var = [
		'pcMenuItems' => $pcMenuItems,
		'menu1' => $menu1,
        'menu2' => $menu2,
        'menu3' => $menu3,
	];

    // $str .= ShowTplTemp($TempArr["end"], $var);
	$str = ShowTplTemp($TempArr["start"], $var);
    if (islogin()) {
        $str = str_replace("{#show#}", "display:none;", $str);
    }

    return $str;

}

//�G�ſ��
function MainMenu_s($pid, $sTemp, $tTemp = "")
{

    global $fsql;

    //$str="<ul class=\"sub-menu\">";
	
    $fsql->querylan("select * from {P}_menu where ifshow='1' and pid='$pid' order by xuhao ");
    
    while ($fsql->next_record()) {
        $id = $fsql->f('id');
        /*�h��y���ഫ*/
        $getlans = strTranslate("menu", $id);
        $menu = $getlans['menu'] ? $getlans['menu'] : $fsql->f('menu');
		
        $linktype = $fsql->f('linktype');
        $coltype = $fsql->f('coltype');
        $folder = $fsql->f('folder');
        $url = $fsql->f('url');
        $target = $fsql->f('target');

        $subcoltypeMenu = "";
        switch ($linktype) {

            //1=�����s��
            case "1":
                $menuurl = ROOTPATH . $folder;
                break;

            //2=�~���s��
            case "2":
                $menuurl = $url;
                break;

            //3=�Ҳդ����s��
            case "3":
                list($catcoltype, $catid) = explode(",", $folder);
                $subTemp = '<div><a href="{#menuurl#}" target="{#target#}" class="item font-ss" style="{#active#}">{#menu#}</a></div>';
                //�Ҳդ������
                //$coltypeMenu=coltypeMenu($catcoltype,$catid,$TempArr["list"]);
                $menuurl = "javascript:;";
                $subcoltypeMenu = subcoltypeMenu($catcoltype, $catid, $subTemp);

                break;

            //�s����Ҳ�
            default:

                if ($coltype == "index") {

                    //�����S���B�z
                    if ($GLOBALS["CONF"]["CatchOpen"] == "1") {
                        $menuurl = ROOTPATH;
                    } else {
                        $menuurl = ROOTPATH . "index.php";
                    }

                } else {

                    //���`�Ҳճs��
                    if ($GLOBALS["CONF"]["CatchOpen"] == "1") {
                        $menuurl = ROOTPATH . $coltype . "/";
                    } else {
                        $menuurl = ROOTPATH . $coltype . "/index.php";
                    }
                }

                break;

        }

        $var = array(
            'menu' => $menu,
            'menuurl' => $menuurl,
            'target' => $target,
            'subcoltypemenu' => $subcoltypeMenu,
        );

        if ($menuurl == "" && $subcoltypeMenu == "") {
            $str = "";
        }

        if ($subcoltypeMenu) {
            $str .= ShowTplTemp($tTemp, $var);
        } else {
            $str .= ShowTplTemp($sTemp, $var);
        }

    }
    //$str.="\n</ul>\n";

    if (!$menu) {
        $str = "";
    }

    return $str;

}
function coltypeMenuMainMenu_s($pid, $Temp = "", $sTemp) 
{
    global $fsql;

    //$str="<ul class=\"sub-menu\">";
	
    $fsql->querylan("select * from {P}_menu where ifshow='1' and pid='$pid' order by xuhao ");
    $str = '';
    $mobileStr = '';
    $mobileMenu3Str = '';
    while ($fsql->next_record()) {
        $id = $fsql->f('id');
        /*�h��y���ഫ*/
        $getlans = strTranslate("menu", $id);
        $menu = $getlans['menu'] ? $getlans['menu'] : $fsql->f('menu');
		
        $linktype = $fsql->f('linktype');
        $coltype = $fsql->f('coltype');
        $folder = $fsql->f('folder');
        $url = $fsql->f('url');
        $target = $fsql->f('target');

        $subcoltypeMenu = "";
        $catid = 0;
        $coltype = '';
        switch ($linktype) {

            //1=�����s��
            case "1":
                $menuurl = ROOTPATH . $folder;
                break;

            //2=�~���s��
            case "2":
                $menuurl = $url;
                break;

            //3=�Ҳդ����s��
            case "3":
                list($coltype, $catid) = explode(",", $folder);
                // $subTemp = '<div><a href="{#menuurl#}" target="{#target#}" class="item font-ss" style="{#active#}">{#menu#}</a></div>';
                //�Ҳդ������
                //$coltypeMenu=coltypeMenu($catcoltype,$catid,$TempArr["list"]);
                $menuurl = "javascript:;";
                // $subcoltypeMenu = subcoltypeMenu($catcoltype, $catid, $subTemp);

                break;

            //�s����Ҳ�
            default:

                if ($coltype == "index") {

                    //�����S���B�z
                    if ($GLOBALS["CONF"]["CatchOpen"] == "1") {
                        $menuurl = ROOTPATH;
                    } else {
                        $menuurl = ROOTPATH . "index.php";
                    }

                } else {

                    //���`�Ҳճs��
                    if ($GLOBALS["CONF"]["CatchOpen"] == "1") {
                        $menuurl = ROOTPATH . $coltype . "/";
                    } else {
                        $menuurl = ROOTPATH . $coltype . "/index.php";
                    }
                }

                break;

        }

        
        $var = array(
            'menu' => $menu,
            'menuurl' => $menuurl,
            'target' => $target,
            'subcoltypemenu' => $subcoltypeMenu,
            'id' => 'mobile-life-type-' . $catid,
        );

        $m1str = ShowTplTemp($sTemp['m1'], $var);
        $getstr = subcoltypeMenu($coltype, $catid, $sTemp['m2']);
        $str .= str_replace("{#m2#}", $getstr, $m1str);

        $mobileStr .= ShowTplTemp($sTemp['m3'], $var);

        $menu3Str = ShowTplTemp($sTemp['menu3'], $var);
        $getstr = subcoltypeMenu($coltype, $catid, $sTemp['m2']);
        $mobileMenu3Str .= str_replace("{#m2#}", $getstr, $menu3Str);
        // if ($menuurl == "" && $subcoltypeMenu == "") {
        //     $str = "";
        // }

        // if ($subcoltypeMenu) {
        //     $str .= ShowTplTemp($tTemp, $var);
        // } else {
        //     $str .= ShowTplTemp($sTemp, $var);
        // }

    }
    //$str.="\n</ul>\n";

    // if (!$menu) {
    //     $str = "";
    // }
    
    return [$str, $mobileStr, $mobileMenu3Str];
}
//�Ҳդ������
function coltypeMenu($coltype, $pid = "", $sTemp)
{
    global $wsql;
    if ($pid != "") {
        $scl = "WHERE pid='" . $pid . "'";
    } else {
        $scl = "WHERE pid='0'";
    }

    $str .= "";
    $mobileStr = "";
    $mobileMenu3Str = "";
    // $subTemp = '<div><a href="{#menuurl#}" target="{#target#}" class="item font-ss" style="{#active#}">{#menu#}</a></div>';

    $wsql->query("SELECT * FROM {P}_" . $coltype . "_cat $scl order by xuhao");
    while ($wsql->next_record()) {
        $catid = $wsql->f("catid");
        $getlans = strTranslate($coltype . "_cat", $catid);
        $cat = $getlans['cat'] ? $getlans['cat'] : $wsql->f('cat');
        //$cat = $wsql->f("cat");
        $ifchannel = $wsql->f('ifchannel');
        if ($ifchannel == "1") {
            $link = ROOTPATH . $coltype . "/class/" . $catid . "/";
        } else {
            if ($GLOBALS["CONF"]["CatchOpen"] == "1" && file_exists(ROOTPATH . $coltype . "/class/" . $catid . ".html")) {
                //$link=ROOTPATH.$coltype."/class/".$catid.".html";
                $link = ROOTPATH . "r" . $coltype . "class" . $catid;
            } else {
                //$link=ROOTPATH.$coltype."/class/?".$catid.".html";
                $link = ROOTPATH . $coltype . "class" . $catid;
            }
        }

        
        $var = array(
            'menuurl' => $link,
            'menu' => $cat,
            'target' => $target,
			'active' => '',
            'id' => 'mobile-type-' . $catid
        );
		
        $m1str = ShowTplTemp($sTemp['m1'], $var);
        $getstr = subcoltypeMenu($coltype, $catid, $sTemp['m2']);
        $str .= str_replace("{#m2#}", $getstr, $m1str);

        $mobileStr .= ShowTplTemp($sTemp['m3'], $var);

        $menu3Str = ShowTplTemp($sTemp['menu3'], $var);
        $getstr = subcoltypeMenu($coltype, $catid, $sTemp['m2']);
        $mobileMenu3Str .= str_replace("{#m2#}", $getstr, $menu3Str);
    }
	
    //$str.= "</ul>";
    
    return [$str, $mobileStr, $mobileMenu3Str];
}

function setPageMenu($coltype, $pid = "", $sTemp)
{
    global $wsql;
    if ($pid != "") {
        $scl = "WHERE pid='" . $pid . "'";
    } else {
        $scl = "WHERE pid='0'";
    }

    $str .= "";
    $subTemp = '<div><a href="{#menuurl#}" target="{#target#}" class="item font-ss" style="{#active#}">{#menu#}</a></div>';

    $wsql->query("SELECT * FROM {P}_" . $coltype . "_cat $scl order by xuhao");
    while ($wsql->next_record()) {
        $catid = $wsql->f("catid");
        $getlans = strTranslate($coltype . "_cat", $catid);
        $cat = $getlans['cat'] ? $getlans['cat'] : $wsql->f('cat');
        //$cat = $wsql->f("cat");
        $ifchannel = $wsql->f('ifchannel');
        if ($ifchannel == "1") {
            $link = ROOTPATH . $coltype . "/class/" . $catid . "/";
        } else {
            if ($GLOBALS["CONF"]["CatchOpen"] == "1" && file_exists(ROOTPATH . $coltype . "/class/" . $catid . ".html")) {
                //$link=ROOTPATH.$coltype."/class/".$catid.".html";
                $link = ROOTPATH . "r" . $coltype . "class" . $catid;
            } else {
                //$link=ROOTPATH.$coltype."/class/?".$catid.".html";
                $link = ROOTPATH . $coltype . "class" . $catid;
            }
        }

        $var = array(
            'menuurl' => $link,
            'menu' => $cat,
            'target' => $target,
        );
        $str .= ShowTplTemp($sTemp, $var);
        $getstr = subcoltypeMenu($coltype, $catid, $subTemp);
        $str = str_replace("{#subcoltypemenu#}", $getstr, $str);
    }

    //$str.= "</ul>";

    return $str;
}

function subcoltypeMenu($coltype, $pid = "", $sTemp)
{
    global $tsql;

    if ($coltype == "page") {
        $tsql->query("select folder from {P}_page_group where id='$pid'");
        if ($tsql->next_record()) {
            $folder = $tsql->f('folder');
        }
        $tsql->query("SELECT * FROM {P}_page WHERE groupid='{$pid}' order by xuhao");
        while ($tsql->next_record()) {
            $id = $tsql->f('id');
            $title = $tsql->f('title');
            $url = $tsql->f('url');
            $pagefolder = $tsql->f('pagefolder');

            //連結，如果有跳轉網址則優先跳轉
            if (strlen($url) > 1) {
                if (substr($url, 0, 7) == "http://") {
                    $link = $url;
                } elseif (substr($url, 0, 8) == "https://") {
                    $link = $url;
                } elseif (substr($url, 0, 10) == "javascript") {
                    $link = $url;
                } else {
                    $link = ROOTPATH . $url;
                }
            } else {
                //如果有獨立頁，優先獨立頁
                if ($pagefolder != "" && file_exists(ROOTPATH . "page/" . $folder . "/" . $pagefolder . ".php")) {
                    $link = ROOTPATH . "page/" . $folder . "/" . $pagefolder . ".php";
                } else {
                    if ($GLOBALS["CONF"]["CatchOpen"] == "1" && file_exists(ROOTPATH . "page/" . $folder . "/" . $id . ".html")) {
                        //$link=ROOTPATH."page/".$folder."/".$id.".html";
                        $link = ROOTPATH . $folder . "-" . $id;
                    } else {
                        //$link=ROOTPATH."page/".$folder."/?".$id.".html";
                        $link = ROOTPATH . $folder . $id;
                    }
                }
            }
            //$maybeclass = preg_replace('/\D/', '', $_SERVER['REQUEST_URI']);
            if (!strpos($_SERVER['REQUEST_URI'], 'shopclass')) {
                $maybeclass = preg_replace('/\D/', '', $_SERVER['REQUEST_URI']);
            } else {
                $maybeclass = null;
            }
        
            
            
            $var = array(
                'menuurl' => $link,
                'menu' => $title,
                'target' => $target,
                'active' => $maybeclass == $id ? "color: #01c3ff;" : "",
            );
            $str .= ShowTplTemp($sTemp, $var);

        }
    } else {
        if ($pid != "") {
            $scl = "WHERE pid='" . $pid . "'";
        }

        $tsql->query("SELECT * FROM {P}_" . $coltype . "_cat $scl order by xuhao");
        while ($tsql->next_record()) {
            $catid = $tsql->f("catid");
            $getlans = strTranslate($coltype . "_cat", $catid);
            $cat = $getlans['cat'] ? $getlans['cat'] : $tsql->f('cat');
            //$cat = $tsql->f("cat");
            $ifchannel = $tsql->f('ifchannel');
            if ($ifchannel == "1") {
                $link = ROOTPATH . $coltype . "/class/" . $catid . "/";
            } else {
                if ($GLOBALS["CONF"]["CatchOpen"] == "1" && file_exists(ROOTPATH . $coltype . "/class/" . $catid . ".html")) {
                    //$link=ROOTPATH.$coltype."/class/".$catid.".html";
                    $link = ROOTPATH . "r" . $coltype . "class" . $catid;
                } else {
                    //$link=ROOTPATH.$coltype."/class/?".$catid.".html";
                    $link = ROOTPATH . $coltype . "class" . $catid;
                }
            }

            if (strpos($_SERVER['REQUEST_URI'], 'shopclass')) {
                $maybeclass = preg_replace('/\D/', '', $_SERVER['REQUEST_URI']);
            } else {
                $maybeclass = null;
            }
            
            $var = array(
                'menuurl' => $link,
                'menu' => $cat,
                'target' => $target,
                'active' => $maybeclass == $catid ? "color: #01c3ff;" : "",
            );
            $str .= ShowTplTemp($sTemp, $var);
            $str .= thrcoltypeMenu($coltype, $catid, $sTemp);
        }
    }

    return $str;
}

function thrcoltypeMenu($coltype, $pid = "", $sTemp)
{
    global $fsql;
    if ($pid != "") {
        $scl = "WHERE pid='" . $pid . "'";
    }

    $str .= "<ul>";

    $fsql->query("SELECT * FROM {P}_" . $coltype . "_cat $scl");
    while ($fsql->next_record()) {
        $catid = $fsql->f("catid");
        $cat = $fsql->f("cat");
        $ifchannel = $fsql->f('ifchannel');
        if ($ifchannel == "1") {
            $link = ROOTPATH . $coltype . "/class/" . $catid . "/";
        } else {
            if ($GLOBALS["CONF"]["CatchOpen"] == "1" && file_exists(ROOTPATH . $coltype . "/class/" . $catid . ".html")) {
                $link = ROOTPATH . $coltype . "/class/" . $catid . ".html";
            } else {
                $link = ROOTPATH . $coltype . "/class/?" . $catid . ".html";
            }
        }

        $var = array(
            'menuurl' => $link,
            'menu' => $cat,
            'target' => $target,
        );
        $str .= ShowTplTemp($sTemp, $var);
    }

    $str .= "</ul>";

    return $str;
}

//�����������
function pageMenu($groupid = "")
{
    global $wsql, $tsql;
    if ($groupid != "") {
        $scl = "WHERE id='" . $groupid . "'";
    } else {
        $scl = "WHERE id='1'";
    }

    $str = "";
    $subTemp = '<div class="mobile-series mobile-line"><a href="{#menuurl#}" target="{#target#}" class="title font-w-m">{#menu#}</a></div>';

    $wsql->querylan("SELECT * FROM {P}_page_group $scl order by xuhao");
    if ($wsql->next_record()) {
        $getlans = strTranslate("page_group", $groupid);
        $groupname = $getlans['groupname'] ? $getlans['groupname'] : $wsql->f('groupname');
        $folder = $wsql->f('folder');
        //$str ="<h4>".$groupname."</h4><ul>";

        $tsql->querylan("SELECT * FROM {P}_page where groupid='$groupid' order by xuhao");
        while ($tsql->next_record()) {
            $pageid = $tsql->f('id');
            $title = $tsql->f('title');
            $url = $tsql->f('url');
            $pagefolder = $tsql->f('pagefolder');

            $getlans = strTranslate("page", $pageid);

            $title = $getlans['title'] ? $getlans['title'] : $title;

            if ($pagefolder != "" && file_exists(ROOTPATH . "page/" . $folder . "/" . $pagefolder . ".php")) {
                $link = ROOTPATH . "page/" . $folder . "/" . $pagefolder . ".php";
            } else {
                if ($GLOBALS["CONF"]["CatchOpen"] == "1" && file_exists(ROOTPATH . "page/" . $folder . "/" . $pageid . ".html")) {
                    $link = ROOTPATH . "page/" . $folder . "/" . $pageid . ".html";
                } else {
                    $link = ROOTPATH . "page/" . $folder . "/?" . $pageid . ".html";
                }
            }
            $getstr = "";
            if ($link) {
                $getstr = str_replace("{#menuurl#}", $link, $getstr);
                $getstr = str_replace("{#target#}", $target, $getstr);
                $getstr = str_replace("{#menu#}", $title, $getstr);
            }
            $getstrs .= $getstr;
        }

        $str .= $getstrs;
    }

    $str .= "";

    return $str;
}

function coltypeMenu1($coltype, $pid = "", $sTemp)
{

    $subTemp = '<div><a href="{#menuurl#}" target="{#target#}" class="item font-ss" style="{#active#}">{#menu#}</a></div>';
    if ($pid == 3) {
        $array = ["健康生活", "綠色未來", "故事報導", "體驗"];
    } else {
        $array = ["深入了解 REMA", "加入 REMA CREW"];
    }

    foreach ($array as $key => $value) {
        $link = "";
        $cat = "";
        $target = "";
        $var = array(
            'menuurl' => "http://localhost:3003:80",
            'menu' => $value,
            'target' => "",
        );
        $str .= ShowTplTemp($sTemp, $var);
        $getstr = subcoltypeMenu1($coltype, $pid, $subTemp, $key);
        $str = str_replace("{#subcoltypemenu#}", $getstr, $str);
    }

    return $str;
}

function subcoltypeMenu1($coltype, $pid = "", $sTemp, $key1)
{

    if ($pid == 3) {
        if ($key1 == 0) {
            $array = ["健身攻略", "美味研究室", "心靈平衡"];
        } elseif ($key1 == 1) {
            $array = ["地球村維護計畫", "永續冷知識", "綠化日常"];
        } elseif ($key1 == 2) {
            $array = ["心力量"];
        } elseif ($key1 == 3) {
            $array = ["會員活動", "Meet The People"];
        }
    }

    if ($pid == 4) {
        if ($key1 == 0) {
            $array = ["我們的思維", "為什麼創辦 REMA", "我們的歷程"];
        } elseif ($key1 == 1) {
            $array = ["如何加入 REMA CREW", "獨享權利", "R4 EARTH", "立即加入"];
        }
    }

    foreach ($array as $key => $value) {
        $var = array(
            'menuurl' => "http://localhost:3003:80", //$link,
            'menu' => $value, //$cat,
            'target' => "", //$target,
            'active' => "",
        );
        $str .= ShowTplTemp($sTemp, $var);
        // $str .= thrcoltypeMenu($coltype, $catid, $sTemp);
    }

    //$str.= "</ul>";

    return $str;
}
