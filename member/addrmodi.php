<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <title>{#pagetitle#} {#sitename#}</title>
    <meta name="description" content="{#metacon#}">
    <meta name="Keywords" content="{#metakey#}">
	{#metaimage#}
	{#addmeta#}
	{#addscript#}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{#TM#}img/favicon.ico" rel="icon" />
    <link rel="stylesheet" href="{#TM#}plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{#TM#}plugins/bootstrap-select/css/bootstrap-select.css">
    <link rel="stylesheet" href="{#TM#}css/icomoon/style.css">
    <link rel="stylesheet" href="{#TM#}css/style.css">
    <link rel="stylesheet" href="{#TM#}css/header.css">
    <link rel="stylesheet" href="{#TM#}css/index.css">
    <link rel="stylesheet" href="{#TM#}css/responsive.css">
    
    <script type="text/javascript" src="{#TM#}js/jquery.min.js"></script>
    <!-- wayhunt -->
	<script type=text/javascript src="{#RP#}base/js/form.js"></script>
	<script type=text/javascript src="{#RP#}base/js/custom.js"></script>
</head>
<body>
	
<script language="javascript" src="{#CP#}js/memberset.js"></script>
<script language="javascript" src="{#CP#}js/zone.js"></script>
	
				<form id="memberModify"  method="post" action="" name="regform" >
                    <p class="pull-right">*必填欄位</p>
                    <div class="clearfix"></div>
                    <hr class="hr-10">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="tab-1">
                            <div class="clearfix m-b-30"></div>
                            <div class="row">
                                <!-- list -->
                                <div class="col-xs-4">姓名*</div>
                                <div class="col-xs-7">
                                    <input type="text" name="name" id="name" value="" class="form-control">
                                </div>
                                <div class="clearfix m-b-15"></div>
                                <!-- / list -->
                                <!-- list -->
                                <div class="col-xs-4">國家*</div>
                                <div class="col-xs-7">
                                    <select name="country" class="form-control">
                                    	<option value="臺灣">臺灣</option>
                                    </select>
                                </div>
                                <div class="clearfix m-b-15"></div>
                                <!-- / list -->
                                <!-- list -->
                                <div class="col-xs-4">城市*</div>
                                <div class="col-xs-7">
                                    <select class="form-control" id="Province" onKeyUp='if(window.event.keyCode==13) document.regform.zoneid.focus();'  onChange="provinceSelChange(regform.zoneid,regform.Province.value,'{#zoneid#}',regform.postcode,regform.addr)" name="Province">
										<script language=javascript>document.write(pList.getOptionString('{#Province#}'));</script>
									</select>
                                </div>
                                <div class="clearfix m-b-15"></div>
                                <!-- / list -->
                                <!-- list -->
                                <div class="col-xs-4">鄉鎮區*</div>
                                <div id="zonediv" class="col-xs-7">
                                    <select onKeyUp='if(window.event.keyCode==13) document.regform.regCardNum.focus();' name="zoneid"  class="form-control" onChange="postSelChange(regform.Province.value,regform.zoneid.value,regform.postcode,regform.addr)">
										<script language=javascript>
											document.write(pList.getOptionAreasString(regform.Province.value,regform.zoneid,'{#zoneid#}',1));
										</script>
									</select>
                                </div>
                                <div class="clearfix m-b-15"></div>
                                <!-- / list -->
                                <!-- list -->
                                <div class="col-xs-4">地址*</div>
                                <div class="col-xs-7">
                                    <input type="text" name="addr" id="addr" value="基隆市仁愛區" class="form-control">
                                </div>
                                <div class="clearfix m-b-15"></div>
                                <!-- / list -->
                                <!-- list -->
                                <div class="col-xs-4">郵遞區號</div>
                                <div class="col-xs-7">
                                    <input type="text" name="postcode" id="postcode" value="200" class="form-control">
                                </div>
                                <div class="clearfix m-b-15"></div>
                                <!-- / list -->
                                <!-- list -->
                                <div class="col-xs-4">電話號碼 (行動電話)</div>
                                <div class="col-xs-7">
                                    <input type="text" name="mov" id="mov" class="form-control">
                                </div>
                                <div class="clearfix m-b-15"></div>
                                <!-- / list -->
                                <!-- list -->
                                <div class="col-xs-4">電話號碼 (其他)</div>
                                <div class="col-xs-7">
                                    <input type="text" name="tel" id="tel" class="form-control">
                                </div>
                                <div class="clearfix m-b-15"></div>
                                <!-- / list -->
                            </div>
                            <!-- row -->
                            <div class="clearfix m-b-15"></div>
                        </div>
                        
                    </div>
                    <!-- tab-content -->
                    ※ 請至少輸入一個電話號碼來接收訂單狀態的通知，並請核對號碼是否正確。
                    <hr>
                	<div  id="noticeadd" class="alert alert-danger" style="display:none;"></div>
                    <button type="submit" class="btn btn-black btn-lg" style="width:150px">編輯地址</button>
					<input type="hidden" name="act" value="memberaddredit" />
					<input type="hidden" name="addrid" value="{#addrid#}" />
                </form>
                	
    <script type="text/javascript" src="{#TM#}plugins/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="{#TM#}plugins/bootstrap-select/js/bootstrap-select.min.js"></script>

</body>
</html>