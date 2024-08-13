<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Log;
use App\Order;
use App\ApiConfig;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \App\Console\Commands\Update1::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //每天上午三點同步庫存
        $schedule->call(function () {
            //Log::useDailyFiles(storage_path('logs/api/ACronJob_get_stock.log'));
            //Log::info('ACronJob_get_stock 開始');
            $this->get_stock('max=4000&mix=3500');
            $this->get_stock('max=3500&mix=3000');
            //Log::info('ACronJob_get_stock 結束');
            ApiConfig::create( [ 'name' => 'get_stock', 'input_data' => '4000-3000' , 'status' => '0', 'message'=> 'finish'] );
        })->dailyAt('03:00');
        $schedule->call(function () {
            $this->get_stock('max=3000&mix=2500');
            $this->get_stock('max=2500&mix=2000');
            ApiConfig::create( [ 'name' => 'get_stock', 'input_data' => '3000-2000' , 'status' => '0', 'message'=> 'finish'] );
        })->dailyAt('03:30');
        
        $schedule->call(function () {
            $this->get_stock('max=2000&mix=1500');
            $this->get_stock('max=1500&mix=1000');
            ApiConfig::create( [ 'name' => 'get_stock', 'input_data' => '2000-1000' , 'status' => '0', 'message'=> 'finish'] );
        })->dailyAt('04:00');

        $schedule->call(function () {
            $this->get_stock('max=1000&mix=500');
            $this->get_stock('max=500&mix=1');
            ApiConfig::create( [ 'name' => 'get_stock', 'input_data' => '1000-1' , 'status' => '0', 'message'=> 'finish'] );
        })->dailyAt('04:30');
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command('update:num1')->everyMinute()->evenInMaintenanceMode();
        $schedule->call(function () {
            //Log::useDailyFiles(storage_path('logs/api/ACronJob.log'));
            //===========================================================================================================
            //抓取3/1之後的訂單
            $Order = Order::where('dtime', '>', "1614556800")->get();
            // 找出已經傳輸成功的訂單
            $ApiConfigArray = [];
            $ApiConfig = ApiConfig::where('name', "cre_order")->where('status', "0")->orderBy('id', 'desc')->get();
            foreach($ApiConfig as $key => $value){
                array_push($ApiConfigArray, $value->input_data);
            }
            //判斷沒有傳送的訂單
            foreach($Order as $key => $value){
                if(!in_array($value->orderid , $ApiConfigArray)){
                    //Log::info('orderid='.$value->orderid);
                    $this->cre_order_customer('orderid='.$value->orderid);
                }
            }

            //===========================================================================================================
            //找出需要退貨的訂單iftui
            // $Order = Order::where('dtime', '>', "1614556800")->where('iftui', 1)->get();
            //查尋有退貨沒有穿送的值
            // $ApiConfigArray = [];
            // $ApiConfig = ApiConfig::where('name', "upd_order_complete")->where('status', "0")->orderBy('id', 'desc')->get();
            // foreach($ApiConfig as $key => $value){
            //     array_push($ApiConfigArray, $value->input_data);
            // }
            //判斷沒有傳送退貨的訂單
            // foreach($Order as $key => $value){
            //     if(!in_array($value->orderid , $ApiConfigArray)){
            //         Log::info('orderid='.$value->orderid.'&status=2&oper=黃俊卿');
            //         $this->upd_order_complete('orderid='.$value->orderid.'&status=2&oper=黃俊卿');
            //     }
            // }
        })->everyMinute();

        
        
       // $schedule->command('test')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

    function geturl($url){
        $headerArray =array("Content-type:application/json;","Accept:application/json");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    
    //建立訂單
    function cre_order_customer($post=""){
        $data = $this->geturl(url("/remaapi/customer?".$post));
        return $data;
    }

    //訂單結案
    function upd_order_complete($post=""){
        $data = $this->geturl(url("/remaapi/upd_order_complete?".$post));
        return $data;
    }

    //退貨
    function upd_order_cancel($post=""){
        $data = $this->geturl(url("/remaapi/upd_order_cancel?".$post));
        return $data;
    }

    //查詢訂單商品庫存
    function get_stock($post=""){
        $data = $this->geturl(url("/remaapi/get_stock?".$post));
        return $data;
    }

}
