<?php

namespace App\Console\Commands;

use App\Models\Discount;
use Illuminate\Console\Command;

class DeleteDiscountExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:discounts-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduled command to delete expired discounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Discount::where('end_date', '<=', now())->delete();
        return 0;
    }
}
