<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItems;
use App\ShopCon;
use App\Member;
use App\ShopConspec;
use Log;
use DB;
use App\ApiConfig;
use Mail;
use App\Mail\mail as notificationMail;

class CustomerController extends Controller
{
    public function sendMail($data = null)
    {
        // $data = [ 'name' => 'cre_order', 'input_data' => "25566" , 'status' => "0", 'message1'=> "finished! 0.1(s)" ];
        if($data['status'] != "0"){
            // $emails = array("ppcs0520@yahoo.com.tw","eric@rema-sports.com","richie@rema-sports.com","Celia@rema-sports.com");
            $emails = array("richie@rema-sports.com");
            Mail::send('emails.email', $data, function($m) use ($emails) {
                $m->to($emails);
                $m->from('service@rema-sports.com', 'Rema 銳馬'); 
                $m->subject('Rema API 異常');
            });
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /*public function testing() {
        echo "testing";
        $OrderID = "29830";
        $Order = Order::where('orderid', $OrderID)->get();
        $OrderItems = OrderItems::where('orderid', $OrderID)->get();
        //print_r($Order);
        $data["datas"][0]["orderNo"] = $Order[0]->orderid;
        $data["datas"][0]["orderer"] = empty($Order[0]->name)? $Order[0]->s_name : $Order[0]->name;
        $data["datas"][0]["saleDepCode"] ="0000";
        $data["datas"][0]["orderDate"] = date("Y-m-d H:i:s", $Order[0]->dtime);
        // $data["datas"][0]["saleNum"] = count($OrderItems);
        $data["datas"][0]["saleNum"] = 0;
        $data["datas"][0]["shipFee"] = (int)$Order[0]->yunfei;//multiyunfei;
        $data["datas"][0]["saleDisc"] = 0;//(int)$Order[0]->promoprice;
        $data["datas"][0]["saleAmount"] = (int)$Order[0]->paytotal - (int)$Order[0]->yunfei + (int)$Order[0]->disaccount; //(int)$Order[0]->multiprice + (int)$Order[0]->disaccount;
        $data["datas"][0]["payType"] = $Order[0]->paytype;//paytype
        $data["datas"][0]["sendArea"] = empty($Order[0]->country)? '台灣': $Order[0]->country;
        $data["datas"][0]["sendAddr"] = $Order[0]->s_addr;
        $data["datas"][0]["receName"] = $Order[0]->s_name;
        $data["datas"][0]["receTel"] = empty($Order[0]->mobi)? $Order[0]->s_mobi : $Order[0]->mobi;
        $data["datas"][0]["orderVipNo"] = $Order[0]->memberid;
        $data["datas"][0]["payProc"] = "";//$Order[0]->ifpay payProc    付款進度 (內容參考2.1.3節) 以收 未收
        $data["datas"][0]["sendProc"] = "";//$Order[0]->ifyun sendProc    配送進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["invProc"] = "";//$Order[0]->ifreceipt invProc    發票進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["orderProc"] = "";//$Order[0]->ifok; orderProc    完成進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["remark"] = "備註";
        $data["datas"][0]["mail"] = $Order[0]->email;
        //新增
        $invoBarcode=""; $invoLoveCode="";
        if(!is_null($Order[0]->integrated)){
            $invodata = explode("|", $Order[0]->integrated);
            if($invodata[0] == "手機載具"){
                $invoBarcode = $invodata[1];
            }
        }
        if($Order[0]->contribute!=""){
            $invodata = explode("|", $Order[0]->contribute);
            $invoLoveCode = $invodata[1];
        }
        $data["datas"][0]["invoTitleNo"] = "";//發票統編
        $data["datas"][0]["invoBarcode"] = $invoBarcode;//發票手機載具
        $data["datas"][0]["invoLoveCode"] = $invoLoveCode;//發票愛心捐贈碼
        $OrderItems = json_decode($OrderItems);
        // dd($OrderItems);
        $num_key=0;
        $saleDiscSum = 0;
        $unitPriceAll = 0;
        $salePriceAll = 0;
        print_r($data);
        foreach($OrderItems as $key1 => $value){
            list($buysize, $buyprice, $buyspecid) = explode("^",$value->fz);
            // $data["datas"][0]["bodys"][$key]["styleCode"] = "MCB002 -BA-M";//$value->bn; 組號已有欄位 *色號尚無欄位 尺碼也有欄位
            $ShopCon = ShopCon::where('id', $value->gid)->first();
            //組合商品先分開，看看有幾筆資料
            $arr = explode(",",$ShopCon->posbn);
            $arr_count = count( $arr);
            $num=0;
            if($arr_count==1){
                $data["datas"][0]["saleNum"] = $arr_count + $data["datas"][0]["saleNum"];
                list($bn, $color) = explode("-", $ShopCon->posbn);
                if($buysize != "ONE"){
                    if(strlen($value->bn) == 4 ){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn."   -".$color."-".$buysize;
                    }elseif(strlen($value->bn) == 5 ){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn."  -".$color."-".$buysize;
                    }elseif(strlen($value->bn) == 6 ){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn." -".$color."-".$buysize;
                    }elseif(strlen($value->bn)==7){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $ShopCon->posbn."-".$buysize;
                    }
                }else{
                    if(strlen($value->bn)==4){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."   -".$color."-O";
                    }elseif(strlen($value->bn)==5){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."  ".$color."-O";
                    }elseif(strlen($value->bn)==6){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn." -".$color."-O";
                    }elseif(strlen($value->bn)==7){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."-".$color."-O";
                    }
                }
                
                //計算折扣
                //$discount =((int)$Order[$num]->multiprice + (int)$Order[$num]->disaccount) /  ( (int)$Order[$num]->multiprice + (int)$Order[$num]->promoprice + (int)$Order[$num]->disaccount) ;
                $discount = 1 - ((int)$Order[0]->promoprice/(int)$Order[0]->totalcent);
                
                $data["datas"][$num]["bodys"][$num_key]["styleName"] = $value->goods."(".$value->colorname."/".$buysize."/".$value->nums.")";
                $data["datas"][$num]["bodys"][$num_key]["unitPrice"] = (int)$ShopCon->price != 0 ? (int)$ShopCon->price/$arr_count : (int)$ShopCon->price0/$arr_count;
                $data["datas"][$num]["bodys"][$num_key]["salePrice"] = (int)((int)$value->price * $discount)/$arr_count;
                $data["datas"][$num]["bodys"][$num_key]["saleNum"] = (int)$value->nums;
                $saleDiscSum = $saleDiscSum + $data["datas"][$num]["bodys"][$num_key]["unitPrice"] - $data["datas"][$num]["bodys"][$num_key]["salePrice"];
                $unitPriceAll = $unitPriceAll + $data["datas"][$num]["bodys"][$num_key]["unitPrice"]*$data["datas"][$num]["bodys"][$num_key]["saleNum"];
                $salePriceAll = $salePriceAll + $data["datas"][$num]["bodys"][$num_key]["salePrice"]*$data["datas"][$num]["bodys"][$num_key]["saleNum"];
                $num_key =$num_key+1;
            }else{
                $data["datas"][$num]["saleNum"] = $arr_count + $data["datas"][$num]["saleNum"];
                // $data["datas"][$num]["saleDisc"] += (int)$ShopCon->price0 - (int)$ShopCon->price;
                foreach($arr as $key => $ar){
                    list($bn, $color) = explode("-",$ar);
                    if($buysize != "ONE"){
                        if(strlen($value->bn) == 4 ){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn."   -".$color."-".$buysize;
                        }elseif(strlen($value->bn) == 5 ){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn."  -".$color."-".$buysize;
                        }elseif(strlen($value->bn) == 6 ){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn." -".$color."-".$buysize;
                        }elseif(strlen($value->bn)==7){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $ShopCon->posbn."-".$buysize;
                        }elseif($value->bn=='合購優惠'){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn." -".$color."-".$buysize;
                        }
                    }else{
                        if(strlen($value->bn)==4){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."   -".$color."-O";
                        }elseif(strlen($value->bn)==5){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."  ".$color."-O";
                        }elseif(strlen($value->bn)==6){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn." -".$color."-O";
                        }elseif(strlen($value->bn)==7){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."-".$color."-O";
                        }elseif($value->bn=='合購優惠'){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $arr[$num_key]."-".$buysize;
                        }
                    }
                    //整筆折扣
                    //$discount =((int)$Order[$num]->multiprice + (int)$Order[$num]->disaccount) /  ( (int)$Order[$num]->multiprice + (int)$Order[$num]->promoprice + (int)$Order[$num]->disaccount) ;
                    $discount = 1 - ((int)$Order[0]->promoprice/(int)$Order[0]->totalcent);
                
                    //單筆折扣 //計算折扣-組合架折扣計算
                    $discount_count = (int)$ShopCon->price / (int)$ShopCon->price0; //賣出價格 / 原價 = 折扣
                    

                    $data["datas"][$num]["bodys"][$num_key]["styleName"] = $value->goods."(".$value->colorname."/".$buysize."/".$value->nums.")";
                    $data["datas"][$num]["bodys"][$num_key]["unitPrice"] = (int)$ShopCon->price0/$arr_count;
                    $data["datas"][$num]["bodys"][$num_key]["salePrice"] = round($value->price*$discount/$arr_count);
                    $data["datas"][$num]["bodys"][$num_key]["saleNum"] = (int)$value->nums;
                    $saleDiscSum = $saleDiscSum + (int)$ShopCon->price0/$arr_count - round($value->price*$discount/$arr_count);
                    $unitPriceAll = $unitPriceAll + $data["datas"][$num]["bodys"][$num_key]["unitPrice"]*$data["datas"][$num]["bodys"][$num_key]["saleNum"];
                    $salePriceAll = $salePriceAll + $data["datas"][$num]["bodys"][$num_key]["salePrice"]*$data["datas"][$num]["bodys"][$num_key]["saleNum"];
                    $num_key =$num_key+1;
                }
            }
        }
        //20210804總價減去過程剩下多少
        $lito = $data["datas"][0]["saleAmount"] - $salePriceAll;
        $data["datas"][0]["bodys"][0]["salePrice"] = $data["datas"][0]["bodys"][0]["salePrice"] + $lito;
        
        //20210615計算總折扣價格
        $data["datas"][0]["saleDisc"] = $unitPriceAll - ($salePriceAll + $lito);
         
        print_R(json_encode($data));
    }*/
    public function index(Request $request)
    {
        //呼叫appId
        // $data = $this->posturl($url,$data);
        // print_R($data);

        // ApiConfig::updateOrCreate( [ 'name' => 'cre_order', 'input_data' => '25801' , 'status' => '0', 'message'=> 'finish'] );
        // exit;


        //抓取3/1之後的訂單
        // $Order = Order::where('dtime', '>', "1614556800")->get();
        // 找出已經傳輸成功的訂單
        // $ApiConfigArray = [];
        // $ApiConfig = ApiConfig::where('name', "cre_order")->where('status', "0")->orderBy('id', 'desc')->get();
        // foreach($ApiConfig as $key => $value){
        //     array_push($ApiConfigArray, $value->input_data);
        // }
        //判斷沒有傳送的訂單
        // foreach($Order as $key => $value){
        //     if(!in_array($value->orderid , $ApiConfigArray)){
        //         print_R($value->orderid);
        //         print_R("<br>");
        //     }
        // }
        //===========================================================================================================
        // //找出需要退貨的訂單iftui
        // $Order = Order::where('dtime', '>', "1614556800")->where('iftui', 1)->get();
        // //查尋有退貨沒有穿送的值
        // $ApiConfigArray = [];
        // $ApiConfig = ApiConfig::where('name', "upd_order_complete")->where('status', "0")->orderBy('id', 'desc')->get();
        // foreach($ApiConfig as $key => $value){
        //     array_push($ApiConfigArray, $value->input_data);
        // }
        // //判斷沒有傳送退貨的訂單
        // foreach($Order as $key => $value){
        //     if(!in_array($value->orderid , $ApiConfigArray)){
        //         print_R("aa:".$value->orderid);
        //         print_R("<br>");
        //     }
        // }
        // exit;
        //Log::useDailyFiles(storage_path('logs/api/cre_order.log'));
        //建立data
        date_default_timezone_set('Asia/Taipei');
        $data  = $this->create_dataArray("upOrderData");
        $url = "http://rm501.wpos.com.tw:8899/rfsys/odid/up";
        //補資料
        $OrderID = $request->input('orderid');
        $Order = Order::where('orderid', $OrderID)->get();
        $OrderItems = OrderItems::where('orderid', $OrderID)->get();

        $data["datas"][0]["orderNo"] = $Order[0]->orderid;
        $data["datas"][0]["orderer"] = empty($Order[0]->name)? $Order[0]->s_name : $Order[0]->name;
        $data["datas"][0]["saleDepCode"] ="0000";
        $data["datas"][0]["orderDate"] = date("Y-m-d H:i:s", $Order[0]->dtime);
        // $data["datas"][0]["saleNum"] = count($OrderItems);
        $data["datas"][0]["saleNum"] = 0;
        $data["datas"][0]["shipFee"] = (int)$Order[0]->yunfei;//multiyunfei;
        $data["datas"][0]["saleDisc"] = 0;//(int)$Order[0]->promoprice;
        $data["datas"][0]["saleAmount"] = (int)$Order[0]->paytotal - (int)$Order[0]->yunfei + (int)$Order[0]->disaccount; //(int)$Order[0]->multiprice + (int)$Order[0]->disaccount;
        $data["datas"][0]["payType"] = $Order[0]->paytype;//paytype
        $data["datas"][0]["sendArea"] = empty($Order[0]->country)? '台灣': $Order[0]->country;
        $data["datas"][0]["sendAddr"] = $Order[0]->s_addr;
        $data["datas"][0]["receName"] = $Order[0]->s_name;
        $data["datas"][0]["receTel"] = empty($Order[0]->mobi)? $Order[0]->s_mobi : $Order[0]->mobi;
        $data["datas"][0]["orderVipNo"] = $Order[0]->memberid;
        $data["datas"][0]["payProc"] = "";//$Order[0]->ifpay payProc	付款進度 (內容參考2.1.3節) 以收 未收
        $data["datas"][0]["sendProc"] = "";//$Order[0]->ifyun sendProc	配送進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["invProc"] = "";//$Order[0]->ifreceipt invProc	發票進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["orderProc"] = "";//$Order[0]->ifok; orderProc	完成進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["remark"] = "備註";
        $data["datas"][0]["mail"] = $Order[0]->email;
        //新增
        $invoBarcode=""; $invoLoveCode="";
        if(!is_null($Order[0]->integrated)){
            $invodata = explode("|", $Order[0]->integrated);
            if($invodata[0] == "手機載具"){
                $invoBarcode = $invodata[1];
            }
        }
        if($Order[0]->contribute!=""){
            $invodata = explode("|", $Order[0]->contribute);
            $invoLoveCode = $invodata[1];
        }
        $data["datas"][0]["invoTitleNo"] = "";//發票統編        
        $data["datas"][0]["invoBarcode"] = $invoBarcode;//發票手機載具
        $data["datas"][0]["invoLoveCode"] = $invoLoveCode;//發票愛心捐贈碼
        $OrderItems = json_decode($OrderItems);
        // dd($OrderItems);
        $num_key=0;
        $saleDiscSum = 0;
        $unitPriceAll = 0;
        $salePriceAll = 0;
        foreach($OrderItems as $key1 => $value){
            list($buysize, $buyprice, $buyspecid) = explode("^",$value->fz);
            // $data["datas"][0]["bodys"][$key]["styleCode"] = "MCB002 -BA-M";//$value->bn; 組號已有欄位 *色號尚無欄位 尺碼也有欄位
            $ShopCon = ShopCon::where('id', $value->gid)->first();
            //組合商品先分開，看看有幾筆資料
            $arr = explode(",",$ShopCon->posbn);
            $arr_count = count( $arr);
            $num=0;
            if($arr_count==1){
                $data["datas"][0]["saleNum"] = $arr_count + $data["datas"][0]["saleNum"];
                list($bn, $color) = explode("-", $ShopCon->posbn);
                if($buysize != "ONE"){
                    if(strlen($value->bn) == 4 ){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn."   -".$color."-".$buysize;
                    }elseif(strlen($value->bn) == 5 ){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn."  -".$color."-".$buysize;
                    }elseif(strlen($value->bn) == 6 ){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn." -".$color."-".$buysize;
                    }elseif(strlen($value->bn)==7){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $ShopCon->posbn."-".$buysize;
                    }
                }else{
                    if(strlen($value->bn)==4){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."   -".$color."-O";
                    }elseif(strlen($value->bn)==5){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."  ".$color."-O";
                    }elseif(strlen($value->bn)==6){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn." -".$color."-O";
                    }elseif(strlen($value->bn)==7){
                        $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."-".$color."-O";
                    }
                }
                
                //計算折扣
                //$discount =((int)$Order[$num]->multiprice + (int)$Order[$num]->disaccount) /  ( (int)$Order[$num]->multiprice + (int)$Order[$num]->promoprice + (int)$Order[$num]->disaccount) ;
                $discount = 1 - ((int)$Order[0]->promoprice/(int)$Order[0]->totalcent);
                
                $data["datas"][$num]["bodys"][$num_key]["styleName"] = $value->goods."(".$value->colorname."/".$buysize."/".$value->nums.")";
                $data["datas"][$num]["bodys"][$num_key]["unitPrice"] = (int)$ShopCon->price != 0 ? (int)$ShopCon->price/$arr_count : (int)$ShopCon->price0/$arr_count;
                $data["datas"][$num]["bodys"][$num_key]["salePrice"] = (int)((int)$value->price * $discount)/$arr_count;
                $data["datas"][$num]["bodys"][$num_key]["saleNum"] = (int)$value->nums;
                $saleDiscSum = $saleDiscSum + $data["datas"][$num]["bodys"][$num_key]["unitPrice"] - $data["datas"][$num]["bodys"][$num_key]["salePrice"];
                $unitPriceAll = $unitPriceAll + $data["datas"][$num]["bodys"][$num_key]["unitPrice"]*$data["datas"][$num]["bodys"][$num_key]["saleNum"];
                $salePriceAll = $salePriceAll + $data["datas"][$num]["bodys"][$num_key]["salePrice"]*$data["datas"][$num]["bodys"][$num_key]["saleNum"];
                $num_key =$num_key+1;
            }else{
                $data["datas"][$num]["saleNum"] = $arr_count + $data["datas"][$num]["saleNum"];
                // $data["datas"][$num]["saleDisc"] += (int)$ShopCon->price0 - (int)$ShopCon->price;
                foreach($arr as $key => $ar){
                    list($bn, $color) = explode("-",$ar);
                    if($buysize != "ONE"){
                        if(strlen($value->bn) == 4 ){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn."   -".$color."-".$buysize;
                        }elseif(strlen($value->bn) == 5 ){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn."  -".$color."-".$buysize;
                        }elseif(strlen($value->bn) == 6 ){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn." -".$color."-".$buysize;
                        }elseif(strlen($value->bn)==7){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $ShopCon->posbn."-".$buysize;
                        }elseif($value->bn=='合購優惠'){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $bn." -".$color."-".$buysize;
                        }
                    }else{
                        if(strlen($value->bn)==4){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."   -".$color."-O";
                        }elseif(strlen($value->bn)==5){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."  ".$color."-O";
                        }elseif(strlen($value->bn)==6){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn." -".$color."-O";
                        }elseif(strlen($value->bn)==7){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] =$bn."-".$color."-O";
                        }elseif($value->bn=='合購優惠'){
                            $data["datas"][$num]["bodys"][$num_key]["styleCode"] = $arr[$num_key]."-".$buysize;
                        }
                    }
                    //整筆折扣 
                    //$discount =((int)$Order[$num]->multiprice + (int)$Order[$num]->disaccount) /  ( (int)$Order[$num]->multiprice + (int)$Order[$num]->promoprice + (int)$Order[$num]->disaccount) ;
                    $discount = 1 - ((int)$Order[0]->promoprice/(int)$Order[0]->totalcent);
                
                    //單筆折扣 //計算折扣-組合架折扣計算
                    $discount_count = (int)$ShopCon->price / (int)$ShopCon->price0; //賣出價格 / 原價 = 折扣
                    

                    $data["datas"][$num]["bodys"][$num_key]["styleName"] = $value->goods."(".$value->colorname."/".$buysize."/".$value->nums.")";
                    $data["datas"][$num]["bodys"][$num_key]["unitPrice"] = (int)$ShopCon->price0/$arr_count;
                    $data["datas"][$num]["bodys"][$num_key]["salePrice"] = round($value->price*$discount/$arr_count);
                    $data["datas"][$num]["bodys"][$num_key]["saleNum"] = (int)$value->nums;
                    $saleDiscSum = $saleDiscSum + (int)$ShopCon->price0/$arr_count - round($value->price*$discount/$arr_count);
                    $unitPriceAll = $unitPriceAll + $data["datas"][$num]["bodys"][$num_key]["unitPrice"]*$data["datas"][$num]["bodys"][$num_key]["saleNum"];
                    $salePriceAll = $salePriceAll + $data["datas"][$num]["bodys"][$num_key]["salePrice"]*$data["datas"][$num]["bodys"][$num_key]["saleNum"];
                    $num_key =$num_key+1;
                }
            }
        }
        //20210804總價減去過程剩下多少
        $lito = $data["datas"][0]["saleAmount"] - $salePriceAll;
        $data["datas"][0]["bodys"][0]["salePrice"] = $data["datas"][0]["bodys"][0]["salePrice"] + $lito;
        
        //20210615計算總折扣價格
        $data["datas"][0]["saleDisc"] = $unitPriceAll - ($salePriceAll + $lito);
        
        print_R(json_encode($data));
        //呼叫appId
        $data = $this->posturl($url,$data);
        // print_R($data);
        try{
            $data=json_decode($data, true);
            ApiConfig::updateOrCreate( [ 'name' => 'cre_order', 'input_data' => $OrderID , 'status' => $data['errorCode'], 'message'=> $data['errorMsg'] ] );
            //$this->sendMail( [ 'name' => 'cre_order', 'input_data' => $OrderID , 'status' => $data['errorCode'], 'message1'=> $data['errorMsg'] ] );
        }catch(Exception $i){
            //Log::info("ApiConfig:有錯誤");
        }
    }

    //8.1 從官網系統將訂購單退貨資料更新到鼎宇erp系統。
    function upd_order_cancel(Request $request){
        //Log::useDailyFiles(storage_path('logs/api/upd_order_cancel.log'));
        //Log::info("傳入參數:". json_encode( $request->all()));
        //建立data
        $data  = $this->create_dataArray("upReturnData");
        $url ="http://rm501.wpos.com.tw:8899/rfsys/sas4/up";
        //補資料
        $OrderID = $request->input('orderid');
        $Order = Order::where('orderid', $OrderID)->get();
        $OrderItems = OrderItems::where('orderid', $OrderID)->where('iftui', '1')->get();//itemtui
        $data["datas"]["orderNo"] = $Order[0]->orderid;
        $data["datas"]["oper"] =empty($request->input('oper'))? '客戶退貨': $request->input('oper');
        $data["datas"]["saleDepCode"] ="0000";
        $data["datas"]["orderDate"] = date("Y-m-d H:i:s");
        $data["datas"]["returnNum"] = $OrderItems->count();
        $data["datas"]["shipFee"] = (int)$Order[0]->multiyunfei;
        print_R($OrderItems->count());
        $OrderItems = json_decode($OrderItems);
        foreach($OrderItems as $key => $value){
            list($buysize, $buyprice, $buyspecid) = explode("^",$value->fz);
            $ShopCon = ShopCon::where('id', $value->gid)->first();
            list($bn, $color) = explode("-",$ShopCon->posbn);

            if($buysize != "ONE"){
                if(strlen($value->bn) == 4 ){
                    $data["datas"]["bodys"][$key]["styleCode"] = $bn."   -".$color."-".$buysize;
                }elseif(strlen($value->bn) == 5 ){
                    $data["datas"]["bodys"][$key]["styleCode"] = $bn."  -".$color."-".$buysize;
                }elseif(strlen($value->bn) == 6 ){
                    $data["datas"]["bodys"][$key]["styleCode"] = $bn." -".$color."-".$buysize;
                }elseif(strlen($value->bn)==7){
                    $data["datas"]["bodys"][$key]["styleCode"] = $ShopCon->posbn."-".$buysize;
                }
            }else{
                if(strlen($value->bn)==4){
                    $data["datas"]["bodys"][$key]["styleCode"] =$bn."   -".$color."-O";
                }elseif(strlen($value->bn)==5){
                    $data["datas"]["bodys"][$key]["styleCode"] =$bn."  ".$color."-O";
                }elseif(strlen($value->bn)==6){
                    $data["datas"]["bodys"][$key]["styleCode"] =$bn." -".$color."-O";
                }elseif(strlen($value->bn)==7){
                    $data["datas"]["bodys"][$key]["styleCode"] =$bn."-".$color."-O";
                }
            }

            $data["datas"]["bodys"][$key]["styleName"] = $value->goods."(".$value->colorname."/".$buysize."/".$value->nums.")";
            $data["datas"]["bodys"][$key]["returnNum"] = (int)$value->nums;
        }
        //呼叫appId
        //Log::info("傳入參數:". json_encode($data));
        $data = $this->posturl($url,$data);
        print_R($data);
        //Log::info("傳出參數:". ($data));

        try{
            $data1=json_decode($data, true);
            ApiConfig::updateOrCreate( [ 'name' => 'upd_order_cancel', 'input_data' => $OrderID , 'status' => $data1['errorCode'], 'message'=> $data1['errorMsg'] ] );
            $this->sendMail( [ 'name' => 'upd_order_cancel', 'input_data' => $OrderID , 'status' => $data1['errorCode'], 'message1'=> $data1['errorMsg'] ] );
        }catch(Exception $i){
            //Log::info("ApiConfig:有錯誤");
        }
    }

    // 7.1顧客購買記錄查詢API 從官網系統向鼎宇erp系統查詢。包含門市Pos銷售單與官網結案訂購單的銷售明細
    function get_order_note(Request $request){
        //建立data
        $orderVipNo = $request->input('orderVipNo');
        $data  = $this->create_dataArray("downCar3Data");
        $url ="http://rm501.wpos.com.tw:8899/rfsys/car3";
        //補資料
        $data["orderVipNo"] = $orderVipNo;//10002001
        //呼叫appId
        $data = $this->posturl($url,$data);
        print_R($data);
    }

    // 6.1查詢鼎宇ERP商品存量 // 從官網系統向鼎宇erp系統查詢商品存量。 // 存量計算方式: 倉庫量 + 2家門市存量 – 顧客已訂貨未出貨量
    function get_stock_api(Request $request){
        
        //Log::useDailyFiles(storage_path('logs/api/get_stock_api.log'));
        //建立data
        $data  = $this->create_dataArray("downInp3Data");
        $url ="http://rm501.wpos.com.tw:8899/rfsys/inp3";
        $posproid = $request->input('posproid');
        try{
            if(strstr($posproid, '-')){
                list($bn, $colorsize) = explode("-",$posproid);//1503A03WBL
                $color = substr($colorsize ,0,2);
                $buysize = substr($colorsize ,2,10);
                if($buysize != "ONE"){
                    if(strlen($bn)==4){
                        $data["styleCode"] =$bn."   -".$color."-".$buysize;
                    }elseif(strlen($bn)==5){
                        $data["styleCode"] =$bn."  ".$color."-".$buysize;
                    }elseif(strlen($bn)==6){
                        $data["styleCode"] =$bn." -".$color."-".$buysize;
                    }elseif(strlen($bn)==7){
                        $data["styleCode"] =$bn."-".$color."-".$buysize;
                    }
                }else{
                    if(strlen($bn)==4){
                        $data["styleCode"] =$bn."   -".$color."-O";
                    }elseif(strlen($bn)==5){
                        $data["styleCode"] =$bn."  ".$color."-O";
                    }elseif(strlen($bn)==6){
                        $data["styleCode"] =$bn." -".$color."-O";
                    }elseif(strlen($bn)==7){
                        $data["styleCode"] =$bn."-".$color."-O";
                    }
                }
                // $data["styleCode"] =$bn;
                //呼叫appId
                //Log::info("傳入參數:". json_encode($data));
                $data = $this->posturl($url,$data);
                //Log::info("傳出參數:". json_encode($data));
                $data=json_decode($data, true);
                print_R(json_encode($data));
            }
        }catch(HandleExceptions $e){
            print_R($e);
        }
    }
    function get_stock_one(Request $request){
        
        //Log::useDailyFiles(storage_path('logs/api/get_stock_one.log'));
        //建立data
        $data  = $this->create_dataArray("downInp3Data");
        $url ="http://rm501.wpos.com.tw:8899/rfsys/inp3";
        $posproid = $request->input('posproid');
        // print_R($posproid);
        try{
            if(strstr($posproid, '-')){
                list($bn, $colorsize) = explode("-",$posproid);//1503A03WBL
                $color = substr($colorsize ,0,2);
                $buysize = substr($colorsize ,2,10);
                $this->get_stock($request);

                if($buysize != "ONE"){
                    if(strlen($bn)==4){
                        $data["styleCode"] =$bn."   -".$color."-".$buysize;
                    }elseif(strlen($bn)==5){
                        $data["styleCode"] =$bn."  ".$color."-".$buysize;
                    }elseif(strlen($bn)==6){
                        $data["styleCode"] =$bn." -".$color."-".$buysize;
                    }elseif(strlen($bn)==7){
                        $data["styleCode"] =$bn."-".$color."-".$buysize;
                    }
                }else{
                    if(strlen($bn)==4){
                        $data["styleCode"] =$bn."   -".$color."-O";
                    }elseif(strlen($bn)==5){
                        $data["styleCode"] =$bn."  ".$color."-O";
                    }elseif(strlen($bn)==6){
                        $data["styleCode"] =$bn." -".$color."-O";
                    }elseif(strlen($bn)==7){
                        $data["styleCode"] =$bn."-".$color."-O";
                    }
                }
                // $data["styleCode"] =$bn;
                //呼叫appId
                $data = $this->posturl($url,$data);
                $data=json_decode($data, true);
                try{
                    if($request->input('shopContent')){
                        ApiConfig::updateOrCreate( [ 'name' => 'get_stock_one', 'input_data' => $posproid , 'status' => $data['errorCode'], 'message'=> $data['errorMsg'] ] );
                    }
                }catch(Exception $i){
                    //Log::info("ApiConfig:有錯誤");
                }
                // print_R($data);
                if($data['errorCode'] == 0){
                    if(!$data['datas'] == null){
                        foreach($data['datas'] as $datas){
                            ShopConspec::where('posproid', $posproid)->update(['stocks' => $datas['orderableNum']]);
                            return $datas['orderableNum'];
                        }
                        //更新目前的總庫存量
                        $gid = ShopConspec::where('posproid', $posproid)->first();
                        $data2 = ShopConspec::where('gid', $gid->gid)->groupBy('gid')->selectRaw('sum(stocks) as sum , gid')->first();
                        ShopCon::where('id', $gid->gid)->update(['kucun' => $data2->sum]);
                    }else{
                        ShopConspec::where('posproid', $posproid)->update(['stocks' => 0]);
                        return 0;
                    }
                }
            }
            return -1;
        }catch(HandleExceptions $e){
            return -1;
        }
    }
    function get_stock(Request $request){

        //Log::useDailyFiles(storage_path('logs/api/get_stock.log'));
        if(isset($request->mix)){
            $mix = $request->input('mix');
            $max = $request->input('max');
            $Member = ShopConspec::where('id', '<=', $max)->where('id', '>=', $mix)->whereNotIn('id', [385,388,706,707,719,751,753,795,796,797,1173,1174,1175,1182,1211,1214,1215,1226, 1227, 1228])->get();
        }else{
            $posproid = $request->input('posproid');
            list($bn, $colorsize) = explode("-",$posproid);
            $Member = ShopConspec::where('posproid', 'like', '%'.$bn.'%')->get();
        }

        foreach($Member as $Members){
            
            //建立data
            $data  = $this->create_dataArray("downInp3Data");
            $url ="http://rm501.wpos.com.tw:8899/rfsys/inp3";
            $o_data = $Members->posproid;
            // print_R($o_data);
            try{
                if(strstr($Members->posproid, '-')){
                    list($bn, $colorsize) = explode("-",$Members->posproid);//1503A03WBL
                    $color = substr($colorsize ,0,2);
                    $buysize = substr($colorsize ,2,10);
                    //USC001 -BA-ONE
                    if($buysize != "ONE"){
                        if(strlen($bn)==4){
                            $data["styleCode"] =$bn."   -".$color."-".$buysize;
                        }elseif(strlen($bn)==5){
                            $data["styleCode"] =$bn."  ".$color."-".$buysize;
                        }elseif(strlen($bn)==6){
                            $data["styleCode"] =$bn." -".$color."-".$buysize;
                        }elseif(strlen($bn)==7){
                            $data["styleCode"] =$bn."-".$color."-".$buysize;
                        }
                    }else{
                        if(strlen($bn)==4){
                            $data["styleCode"] =$bn."   -".$color."-O";
                        }elseif(strlen($bn)==5){
                            $data["styleCode"] =$bn."  ".$color."-O";
                        }elseif(strlen($bn)==6){
                            $data["styleCode"] =$bn." -".$color."-O";
                        }elseif(strlen($bn)==7){
                            $data["styleCode"] =$bn."-".$color."-O";
                        }
                    }
                    // $data["styleCode"] =$bn;
                    //呼叫appId
                    //Log::info("傳入參數:". json_encode($data));
                    $data = $this->posturl($url,$data);
                    //Log::info("傳出參數:". json_encode($data));
                    $data=json_decode($data, true);
                    print_R($data);
                    print_R('<br><br><br>');
                    if($data['errorCode'] == 0){
                        if(!$data['datas'] == null){
                            foreach($data['datas'] as $datas){
                                ShopConspec::where('posproid', $o_data)->update(['stocks' => $datas['orderableNum']]);
                            }
                        }else{
                            ShopConspec::where('posproid', $o_data)->update(['stocks' => 0]);
                        }
                    }
                }
            }catch(HandleExceptions $e){
                //print_R($e);
            }
            
        }
        
        //更新目前的總庫存量
        $dataShopConspec = ShopConspec::groupBy('gid')->selectRaw('sum(stocks) as sum , gid')->get();
        foreach($dataShopConspec as $datasShopConspec){
            ShopCon::where('id', $datasShopConspec->gid)->update(['kucun' => $datasShopConspec->sum]);
        }
    }

    //5.1同步顧客資料至鼎宇ERP // 從官網系統將顧客資料同步到鼎宇erp系統，使用此API
    function cre_member_one(Request $request){
        //建立會員
        //Log::useDailyFiles(storage_path('logs/api/cre_member_one.log'));
        date_default_timezone_set('Asia/Taipei');
        //補資料
        // $memberid = $request->input('memberid');
        //$Member = Member::whereIn('memberid', array($memberid))->get();
        $mix = $request->input('mix');
        $max = $request->input('max');
        $Member = Member::where('memberid', '<=', $max)->where('memberid', '>=', $mix)->get();
        foreach($Member as $Members){
            //建立data
            $data  = $this->create_dataArray("upVipData");
            $url = "http://rm501.wpos.com.tw:8899/rfsys/vmmu/up";
            $MemberID = $Members->memberid;
            //Log::info("傳入會員參數:".$Members);
            $data["datas"][0]["id"] = $MemberID;
            $data["datas"][0]["vipCode"] =  $MemberID;
            $data["datas"][0]["vipName"] =  empty($Members->name) ? "無名氏" : mb_substr($Members->name, 0, 10,'utf8');
            $data["datas"][0]["storeCode"] = "remaspor";
            $data["datas"][0]["cardCode"] = "A";
            if($Members->sex == "1")
                $data["datas"][0]["sex"] = "男";
            else
                $data["datas"][0]["sex"] = "女";
            $data["datas"][0]["mail"] = $Members->email;
            $data["datas"][0]["mobile"] = empty($Members->mov)? "無電話" : mb_substr($Members->mov, 0, 20,'utf8');//substr($Members->mov , 0 , 20);
            $data["datas"][0]["height"] = empty($Members->tall) ? 1 : (int)$Members->tall;
            $data["datas"][0]["weight"] = empty($Members->weight) ? 1 : (int)$Members->weight;
            $data["datas"][0]["address"] = empty($Members->addr) ? "無地址" : $Members->addr;
            $data["datas"][0]["idCode"] = "";
            $data["datas"][0]["birthday"] = date('Y-m-d', strtotime($Members->birthday));//$request['Year_ID']."-".$request['Month_ID']."-".$request['Day_ID'];
            $data["datas"][0]["regdate"] = date("Y-m-d H:i:s");
            //Log::info("傳入ERP API參數:".json_encode($data));
            $data = $this->posturl($url,$data);
            //Log::info("ERP API傳出參數:".$data);
            $data=json_decode($data, true);
            print_R($data);
        }
    }

    function cre_member(Request $request){
        
        //Log::useDailyFiles(storage_path('logs/api/cre_member.log'));
        if( $request->input('email') == null ){
            print("你是誰為甚麼要這樣，發生異常");
            //Log::info("你是誰為甚麼要這樣，發生異常:");
            exit;
        }
        date_default_timezone_set('Asia/Taipei');
        //建立data
        $data  = $this->create_dataArray("upVipData");
        $url = "http://rm501.wpos.com.tw:8899/rfsys/vmmu/up";
        //補資料
        $email = $request->input('email');
        $sex = $request->input('sex');
        $Member = Member::where('user', $email)->get();
        $MemberID = $Member[0]->memberid;
        //Log::info("傳入會員參數:".$Member);
        $data["datas"][0]["id"] = $MemberID;
        $data["datas"][0]["vipCode"] =  $MemberID;
        $data["datas"][0]["vipName"] =  $request->input('name');
        $data["datas"][0]["storeCode"] = "remaspor";
        $data["datas"][0]["cardCode"] = "A";
        if($sex == "1")
            $data["datas"][0]["sex"] = "男";
        else
            $data["datas"][0]["sex"] = "女";
        $data["datas"][0]["mail"] = $email;
        $data["datas"][0]["mobile"] = empty($Member[0]->mov)? "無電話" : substr($Member[0]->mov , 0 , 20);
        $data["datas"][0]["height"] = empty($Member[0]->tall) ? 1 : (int)$Member[0]->tall;
        $data["datas"][0]["weight"] = empty($Member[0]->weight) ? 1 : (int)$Member[0]->weight;
        $data["datas"][0]["address"] = empty($Member[0]->addr) ? "無地址" : $Member[0]->addr;
        $data["datas"][0]["idCode"] = "";
        $data["datas"][0]["birthday"] = date('Y-m-d', strtotime($request['Year_ID']."-".$request['Month_ID']."-".$request['Day_ID']));
        $data["datas"][0]["regdate"] = date("Y-m-d H:i:s");
        //呼叫appId
        //Log::info("傳入ERP API參數:".json_encode($data));
        $data = $this->posturl($url,$data);
        //Log::info("ERP API傳出參數:".$data);
        try{
            $data=json_decode($data, true);
            ApiConfig::updateOrCreate( [ 'name' => 'cre_member', 'input_data' => $MemberID , 'status' => $data['errorCode'], 'message'=> $data['errorMsg'] ] );
            $this->sendMail( [ 'name' => 'cre_member', 'input_data' => $MemberID , 'status' => $data['errorCode'], 'message1'=> $data['errorMsg'] ] );
        }catch(Exception $i){
            //Log::info("ApiConfig:有錯誤");
        }
    }

    //4.1更新訂單處理進度至鼎宇ERP
    function upd_order_complete(Request $request){
        //Log::useDailyFiles(storage_path('logs/api/upd_order_complete.log'));
        //Log::info("傳入參數:".json_encode($request->all()));
        if( $request->input('orderid') == null ){
            print("你是誰為甚麼要這樣，發生異常");
            //Log::info("你是誰為甚麼要這樣，發生異常:");
            exit;
        }
        //建立data
        date_default_timezone_set('Asia/Taipei');
        $data  = $this->create_dataArray("upSaleData");
        $url = "http://rm501.wpos.com.tw:8899/rfsys/sas3/up";
        //補資料
        $OrderID = $request->input('orderid');
        $status = $request->input('status');
        $data["orderNo"] = $OrderID;//orderid
        $data["oper"] =empty($request->input('oper'))? '客戶退貨': $request->input('oper');
        if($status == "1"){
            $data["procCode"] = "orderProc";//對應表cpp_member_paycenter 六種付款 payid
            $data["procContent"] = "完成";//paytype $request->input('paytype');
        }else if($status == "2"){
            $data['procCode'] = "orderProc";
            $data["procContent"] = "取消";
        }else if($status == "3"){
            $data['procCode'] = "orderProc";
            $data["procContent"] = "退貨";
        }
        //Log::info("傳入參數:".json_encode($data));
        //呼叫appId
        $data = $this->posturl($url,$data);
        //Log::info("ERP API傳出參數:".$data);
        
        try{
            $data1=json_decode($data, true);
            ApiConfig::updateOrCreate( [ 'name' => 'upd_order_complete', 'input_data' => $OrderID , 'status' => $data1['errorCode'], 'message'=> $data1['errorMsg'] ] );
            $this->sendMail( [ 'name' => 'upd_order_complete', 'input_data' => $OrderID , 'status' => $data1['errorCode'], 'message1'=> $data1['errorMsg'] ] );
        }catch(Exception $i){
            //Log::info("ApiConfig:有錯誤");
        }
        return $data;
    }

    //3.1更新訂單處理進度至鼎宇ERP
    function upd_order(Request $request){

        //Log::useDailyFiles(storage_path('logs/api/upd_order.log'));
        //Log::info("傳入參數:".json_encode($request->all()));
        if( $request->input('orderid') == null ){
            print("你是誰為甚麼要這樣，發生異常");
            //Log::info("你是誰為甚麼要這樣，發生異常:");
            exit;
        }
        //建立data
        date_default_timezone_set('Asia/Taipei');
        $data  = $this->create_dataArray("upOdaProc");
        $url = "http://rm501.wpos.com.tw:8899/rfsys/odaproc";
        //補資料
        $OrderID = $request->input('orderid');
        $status = $request->input('status');
        $data["orderNo"] = $OrderID;//orderid
        $data["oper"] =$request->input('oper');
        if($status == "1"){
            $data["procCode"] = "payProc";//對應表cpp_member_paycenter 六種付款 payid
            $data["procContent"] = "付款";//paytype $request->input('paytype');
        }else if($status == "2"){
            $data['procCode'] = "sendProc";
            $data["procContent"] = "配送";
        }else if($status == "3"){
            $data['procCode'] = "invProc";
            $data["procContent"] = "開立";
        }else if($status =="4"){
            $data['procCode'] = "invProc";
            $data["procContent"] = "取消";//發票作廢
        }
        //Log::info("傳入參數:".json_encode($data));
        //呼叫appId
        $data = $this->posturl($url,$data);
        //Log::info("ERP API傳出參數:".$data);

        try{
            $data1=json_decode($data, true);
            //$this->sendMail( [ 'name' => 'upd_order', 'input_data' => $OrderID , 'status' => $data1['errorCode'], 'message1'=> $data1['errorMsg'] ] );
        }catch(Exception $i){
            //Log::info("ApiConfig:有錯誤");
        }
    }

    //2.1同步訂單資料至鼎宇ERP 從官網系統將客訂單資料同步到鼎宇erp系統，使用此API
    function cre_order(Request $request){
        
        //Log::useDailyFiles(storage_path('logs/api/cre_order.log'));
        //Log::info("傳入參數:".json_encode($request->all()));
        if( $request->input('orderid') == null ){
            print("你是誰為甚麼要這樣，發生異常");
            //Log::info("你是誰為甚麼要這樣，發生異常:");
            exit;
        }
        //建立data
        date_default_timezone_set('Asia/Taipei');
        $data  = $this->create_dataArray("upOrderData");
        $url = "http://rm501.wpos.com.tw:8899/rfsys/odid/up";
        //補資料
        $OrderID = $request->input('orderid');
        $Order = Order::where('orderid', $OrderID)->get();
        $OrderItems = OrderItems::where('orderid', $OrderID)->get();
        $data["datas"][0]["orderNo"] = $Order[0]->orderid;
        $data["datas"][0]["orderer"] = empty($Order[0]->name)? $Order[0]->s_name : $Order[0]->name;
        $data["datas"][0]["saleDepCode"] ="0000";
        $data["datas"][0]["orderDate"] = date("Y-m-d H:i:s", $Order[0]->dtime);
        $data["datas"][0]["saleNum"] = count($OrderItems);
        $data["datas"][0]["shipFee"] = (int)$Order[0]->yunfei;//multiyunfei
        $data["datas"][0]["saleDisc"] = (int)$Order[0]->promoprice;
        $data["datas"][0]["saleAmount"] = (int)$Order[0]->paytotal - (int)$Order[0]->yunfei + (int)$Order[0]->disaccount;
        $data["datas"][0]["payType"] = $Order[0]->paytype;//paytype
        $data["datas"][0]["sendArea"] = empty($Order[0]->country)? '台灣': $Order[0]->country;
        $data["datas"][0]["sendAddr"] = $Order[0]->s_addr;
        $data["datas"][0]["receName"] = $Order[0]->s_name;
        $data["datas"][0]["receTel"] = empty($Order[0]->mobi)? $Order[0]->s_mobi : $Order[0]->mobi;
        $data["datas"][0]["orderVipNo"] = $Order[0]->memberid;
        $data["datas"][0]["payProc"] = "";//$Order[0]->ifpay payProc	付款進度 (內容參考2.1.3節) 以收 未收
        $data["datas"][0]["sendProc"] = "";//$Order[0]->ifyun sendProc	配送進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["invProc"] = "";//$Order[0]->ifreceipt invProc	發票進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["orderProc"] = "";//$Order[0]->ifok; orderProc	完成進度 (內容參考2.1.3節) 1 or 0
        $data["datas"][0]["remark"] = "備註";
        //$data["datas"][0]["invoTitleNo"] = $Order[0]->invoicenumber;
        $data["datas"][0]["mail"] = $Order[0]->email;
        //新增 20210407
        $invoBarcode=""; $invoLoveCode="";
        if(!is_null($Order[0]->integrated)){
            $invodata = explode("|", $Order[0]->integrated);
            if($invodata[0] == "手機載具"){
                $invoBarcode = $invodata[1];
            }
        }
        if($Order[0]->contribute!=""){
            $invodata = explode("|", $Order[0]->contribute);
            $invoLoveCode = $invodata[1];
        }
        $data["datas"][0]["invoTitleNo"] = "";//發票統編        
        $data["datas"][0]["invoBarcode"] = $invoBarcode;//發票手機載具
        $data["datas"][0]["invoLoveCode"] = $invoLoveCode;//發票愛心捐贈碼
        $OrderItems = json_decode($OrderItems);
        $unitPriceAll = 0;
        $salePriceAll = 0;
        foreach($OrderItems as $key => $value){
            list($buysize, $buyprice, $buyspecid) = explode("^",$value->fz);
            // $data["datas"][0]["bodys"][$key]["styleCode"] = "MCB002 -BA-M";//$value->bn; 組號已有欄位 *色號尚無欄位 尺碼也有欄位
            $ShopCon = ShopCon::where('id', $value->gid)->first();
            list($bn, $color) = explode("-",$ShopCon->posbn);

            if($buysize != "ONE"){
                if(strlen($bn) == 4 ){
                    $data["datas"][0]["bodys"][$key]["styleCode"] = $bn."   -".$color."-".$buysize;
                }elseif(strlen($bn) == 5 ){
                    $data["datas"][0]["bodys"][$key]["styleCode"] = $bn."  -".$color."-".$buysize;
                }elseif(strlen($bn) == 6 ){
                    $data["datas"][0]["bodys"][$key]["styleCode"] = $bn." -".$color."-".$buysize;
                }elseif(strlen($bn)==7){
                    $data["datas"][0]["bodys"][$key]["styleCode"] = $ShopCon->posbn."-".$buysize;
                }
            }else{
                if(strlen($bn)==4){
                    $data["datas"][0]["bodys"][$key]["styleCode"] =$bn."   -".$color."-O";
                }elseif(strlen($bn)==5){
                    $data["datas"][0]["bodys"][$key]["styleCode"] =$bn."  ".$color."-O";
                }elseif(strlen($bn)==6){
                    $data["datas"][0]["bodys"][$key]["styleCode"] =$bn." -".$color."-O";
                }elseif(strlen($bn)==7){
                    $data["datas"][0]["bodys"][$key]["styleCode"] =$bn."-".$color."-O";
                }
            }
            //計算折扣
            // $discount =(int)$Order[0]->multiprice /  ( (int)$Order[0]->multiprice + (int)$Order[0]->promoprice + (int)$Order[0]->disaccount) ;
            $discount = 1 - ((int)$Order[0]->promoprice/(int)$Order[0]->totalcent);

            $data["datas"][0]["bodys"][$key]["styleName"] = $value->goods."(".$value->colorname."/".$buysize."/".$value->nums.")";
            $data["datas"][0]["bodys"][$key]["unitPrice"] = (int)$ShopCon->price != 0 ? (int)$ShopCon->price : (int)$ShopCon->price0;
            $data["datas"][0]["bodys"][$key]["salePrice"] = round((int)$value->price * $discount);
            $data["datas"][0]["bodys"][$key]["saleNum"] = (int)$value->nums;
            $unitPriceAll = $unitPriceAll + $data["datas"][0]["bodys"][$key]["unitPrice"]*$data["datas"][0]["bodys"][$key]["saleNum"];
            $salePriceAll = $salePriceAll + $data["datas"][0]["bodys"][$key]["salePrice"]*$data["datas"][0]["bodys"][$key]["saleNum"];
        }
        //20210816 新增
        $data["datas"][0]["saleAmount"] = $salePriceAll;
        $data["datas"][0]["saleDisc"] = $unitPriceAll - $salePriceAll;

        //Log::info("傳入參數:".json_encode($data));
        //呼叫appId
        $data = $this->posturl($url,$data);
        print_R($data);
        //Log::info("ERP API傳出參數:".$data);
        try{
            $data=json_decode($data, true);
            ApiConfig::updateOrCreate( [ 'name' => 'cre_order', 'input_data' => $OrderID , 'status' => $data['errorCode'], 'message'=> $data['errorMsg'] ] );
            $this->sendMail( [ 'name' => 'cre_order', 'input_data' => $OrderID , 'status' => $data['errorCode'], 'message1'=> $data['errorMsg'] ] );
        }catch(Exception $i){
            //Log::info("ApiConfig:有錯誤");
        }
    }
    
    //共用函數
    function create_dataArray($actionType=""){
        $data["actionType"] = $actionType;
        $data["appId"]      = env("appId");
        $data["timeStamp"]  = strtotime("now");
        $appSecret = env("appSecret");
        $Signstr= $actionType.$data["appId"].$appSecret.$data["timeStamp"];
        $Sign=Strtolower(md5($Signstr));
        $data["sign"]   = $Sign;
        return $data;
    }

    //共用函數
    function posturl($url,$data){
        $data  = json_encode($data);
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //傳出data
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
        // return json_decode($output,true);
    }

    function getToday(){
        $today = getdate();
        date("Y/m/d H:i");  //日期格式化
        $year=$today["year"]; //年 
        $month=$today["mon"]; //月
        $day=$today["mday"];  //日
     
        if(strlen($month)=='1')$month='0'.$month;
        if(strlen($day)=='1')$day='0'.$day;
        $today=$year."-".$month."-".$day;
        //echo "今天日期 : ".$today;
        return $today;
    }

}
