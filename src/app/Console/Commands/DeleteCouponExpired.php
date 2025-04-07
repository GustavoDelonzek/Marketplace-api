<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use Illuminate\Console\Command;

class DeleteCouponExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:coupons-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule command to delete expired coupons';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Coupon::where('end_date', '<=', now())->delete();
        return 0;
    }
}
