<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Log;
class Update1 extends Command
{
    // 取名你要下的指令名稱，可以和 class name 不同
    protected $signature = 'update:num1';
    // 簡單的功能描述
    protected $description = 'Update num1 Sum';
    public function __construct()
    {
        parent::__construct();
    }
    // 這個命要要執行的內容
    public function handle()
    {
        Log::useDailyFiles(storage_path('logs/api/ACronJob.log'));
        Log::info("傳入參數:");
    }
}
?>