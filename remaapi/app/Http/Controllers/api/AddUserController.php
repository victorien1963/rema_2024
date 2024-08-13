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

class AddUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(Request $request)
    {
        //建立會員
        Log::useDailyFiles(storage_path('logs/api/cre_member_offline.log'));
        date_default_timezone_set('Asia/Taipei');
        Log::info("傳入會員參數:".json_encode($request->all()));
        if($request->sign != '35d582c4c7d0397dffde78151154e38e'){
            return response()->json(['status'=>'error' , 'message'=>"sign 錯誤"]); 
        }
        if($request->datas){
            foreach($request->datas as $data){
                if($data['id'] > '10000001'){
                    $data['memberid'] = isset($data['id'])? $data['id'] : '' ; unset($data['id']);
                    $data['name'] = isset($data['vipName'])? $data['vipName'] : ''; unset($data['vipName']);
                    $data['mov'] = isset($data['mobile'])? $data['mobile'] : '';
                    $data['password'] = isset($data['mobile'])? md5($data['mobile']) : ''; unset($data['mobile']);
                    $data['regtime'] = isset($data['regdate'])? strtotime($data['regdate']) : ''; unset($data['regdate']);
                    $data['user'] = isset($data['mail'])? $data['mail'] : ''; 
                    $data['email'] = isset($data['mail'])? $data['mail'] : ''; 
                    $data['pname'] = isset($data['mail'])? $data['mail'] : ''; unset($data['mail']);
                    $data['birthday'] = isset($data['birthday'])? strtotime($data['birthday']) : ''; unset($data['birthday']);
                    $data['addr'] = isset($data['address'])? $data['address'] : ''; unset($data['address']);
                    $data['tall'] = isset($data['height'])? $data['height'] : ''; unset($data['height']);
                    $data['sex'] =  isset($data['sex'])? ($data['sex']=="男"? "1": "2") : '';
                    $data['membertypeid'] = '1';
                    $data['membergroupid'] = '1';
                    $data['rz'] = '1';
                    // $data['weight'] = isset($data['weight'])? $data['weight'] : ''; unset($data['weight']);

                    $member = DB::table('cpp_member_offline')->where('email', $data['email'])->where('memberid', $data['memberid'])->first();
                    if ($member !== null) {
                        //更新會員
                        DB::table('cpp_member_offline')->where('email', $data['email'])->where('memberid', $data['memberid'])->update($data);
                    } else {
                        //增加會員
                        DB::table('cpp_member_offline')->insert($data);
                    }
                }
            }
        }
        return response()->json([ 'status' => 'success', 'message' => '建立完成' ]);
    }

    public function update(){

        // echo md5('0977301315');
        $data = DB::table('cpp_member_offline')->get();
        foreach( $data as $value){
            if(!in_array($value->memberid , [0,10000001,77777777])){
                $data1['memberid'] = $value->memberid;
                $data1['secureid'] = '114'; 
                $data1['securetype'] = 'func';
                $data1['secureset'] = '0';
                DB::table('cpp_member_rights')->insert($data1);

                $data1['memberid'] = $value->memberid;
                $data1['secureid'] = '113'; 
                $data1['securetype'] = 'func';
                $data1['secureset'] = '0';
                DB::table('cpp_member_rights')->insert($data1);

                $data1['memberid'] = $value->memberid;
                $data1['secureid'] = '112'; 
                $data1['securetype'] = 'func';
                $data1['secureset'] = '0';
                DB::table('cpp_member_rights')->insert($data1);

                $data1['memberid'] = $value->memberid;
                $data1['secureid'] = '111'; 
                $data1['securetype'] = 'func';
                $data1['secureset'] = '0';
                DB::table('cpp_member_rights')->insert($data1);

                $data1['memberid'] = $value->memberid;
                $data1['secureid'] = '101'; 
                $data1['securetype'] = 'con';
                $data1['secureset'] = '1';
                DB::table('cpp_member_rights')->insert($data1);
            }
        //     // $data1['password'] = isset($value->mov)? md5($value->mov) : '';
        //     // $data1['email'] = isset($value->user)? $value->user : ''; 
        //     // $data1['pname'] = isset($value->user)? $value->user : '';
        //     $data1['membertypeid'] = '1';
        //     $data1['membergroupid'] = '1';
        //     //
        //     DB::table('cpp_member_offline')->where('memberid', $value->memberid)->update($data1);
        }
    }
}
