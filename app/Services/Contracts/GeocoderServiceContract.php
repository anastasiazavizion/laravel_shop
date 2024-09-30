<?php
namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Model;

interface GeocoderServiceContract
{
    public function setCoordinates(Model $model): void;

}
