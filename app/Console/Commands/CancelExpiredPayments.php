<?php

namespace App\Console\Commands;

use App\Models\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CancelExpiredPayments extends Command
{
    protected $signature = 'payments:cancel-expired';

    protected $description = 'Cancel pending payments after their expiry time.';

    public function handle(): int
    {
        if (!Schema::hasTable('payments')) {
            $this->info('Payments table does not exist yet.');

            return self::SUCCESS;
        }

        $count = Payment::where('status', Payment::STATUS_PENDING)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->update([
                'status' => Payment::STATUS_CANCELLED,
                'cancelled_at' => now(),
                'updated_at' => now(),
            ]);

        $this->info("Cancelled {$count} expired payments.");

        return self::SUCCESS;
    }
}
