<?php
namespace App\Services;

use App\Models\OrderCoordinate;
use App\Services\Contracts\GeocoderServiceContract;
use Illuminate\Database\Eloquent\Model;

class GeocoderService implements GeocoderServiceContract
{
    public function setCoordinates(Model $model): void{

        if(!method_exists($model, 'coordinates')){
            throw new \Exception( "Model $model doesn't have relation coordinates", 500);
        }else{
            $results = app("geocoder")
                ->geocode("$model->city $model->address")
                ->get();
            if($results->isNotEmpty()){

                $coordinates = $results[0]->getCoordinates();
              
                logs()->info($coordinates->getLatitude());
                logs()->info($coordinates->getLongitude());


                $model->coordinates()->updateOrCreate(
                    ['lat' => $coordinates->getLatitude(), 'lng' => $coordinates->getLongitude()]
                );
            }

        }

    }

}
