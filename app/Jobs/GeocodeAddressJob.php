<?php

namespace App\Jobs;

use App\Services\Contracts\GeocoderServiceContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeocodeAddressJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Model $model)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logs()->info('GeocodeAddressJob');
        app(GeocoderServiceContract::class)->setCoordinates($this->model);
    }
}
