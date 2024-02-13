<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class DeleteOldCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-old-coupons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::whereHas("coupons")
            ->whereNotNull('seen_at')
            ->where('seen_at', '<', now()->subDays(30))
            ->delete();

        $this->info("Old coupons deleted");
    }
}
