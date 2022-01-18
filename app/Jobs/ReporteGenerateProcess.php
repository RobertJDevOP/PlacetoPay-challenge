<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ReporteGenerateProcess implements ShouldQueue
{
    use Batchable , Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $sleep;

    public function __construct(int $sleep)
    {
        $this->sleep=$sleep;
    }

    public function handle(): void
    {
       
        sleep($this->sleep);
    }
}
