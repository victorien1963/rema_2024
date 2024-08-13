<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Order;
use App\ApiConfig;

class GetStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getStock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Get Stock';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->get_stock('max=4000&mix=3500');
        $this->get_stock('max=3500&mix=3000');
        $this->get_stock('max=3000&mix=2500');
        $this->get_stock('max=2500&mix=2000');
        $this->get_stock('max=2000&mix=1500');
        $this->get_stock('max=1500&mix=1000');
        $this->get_stock('max=1000&mix=500');
        $this->get_stock('max=500&mix=1');
        ApiConfig::create( [ 'name' => 'get_stock', 'input_data' => 'All' , 'status' => '0', 'message'=> 'finish'] );
    }

    private function geturl($url){
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

    private function get_stock($post=""){
        $data = $this->geturl("http://localhost:80/remaapi/get_stock?".$post);
        return $data;
    }
}
