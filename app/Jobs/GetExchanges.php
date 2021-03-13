<?php

namespace App\Jobs;

use App\Facades\HistoricalData;
use App\Models\Exchange;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class GetExchanges implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Exchanges = HistoricalData::GetExchanges();
        foreach ($Exchanges as $Exchange) {
            $exchange = new Exchange($Exchange);
            try {
                $exchange->saveOrFail();
            }
            catch(Throwable $ex) {
                $this->fail($ex);
            }
        }
    }
}
