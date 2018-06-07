<?php

namespace App\Jobs;

use App\Payments\Contracts\ChargeInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Exception;

class ProcessTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $payment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ChargeInterface $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->payment->processReceivePayment();
        } catch (Exception $e) {
            $this->payment->processChargeBackPayment();
        }
    }
}
