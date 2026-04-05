<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateDeviceStatus extends Command
{
    protected $signature = 'devices:update-status';
    protected $description = 'Mark devices OUT if last_seen_at is older than 5 minutes';

    public function handle()
    {
        $threshold = Carbon::now()->subMinutes(5);
        $table = 'devices'; // change this to your actual table name

        $affected = DB::table($table)
            ->whereNotNull('last_seen_at')
            ->where('last_seen_at', '<', $threshold)
            ->where('status', '!=', 'OUT')
            ->update([
                'status' => 'OUT',
                'updated_at' => Carbon::now(),
            ]);

        $this->info("Devices updated: {$affected}");

        return 0;
    }
}