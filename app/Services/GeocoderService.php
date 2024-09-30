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


                $model->coordinates()->updateOrCreate(
                    ['lat' => $coordinates->getLatitude(), 'lng' => $coordinates->getLongitude()]
                );

           /*
                $coordinates = $results[0]->getCoordinates();

                // Check if an existing coordinate entry exists, if so update it, otherwise create a new one
                $modelCoordinate = $model->coordinates()->first() ?: new OrderCoordinate();

                $modelCoordinate->lat = $coordinates->getLatitude();
                $modelCoordinate->lng = $coordinates->getLongitude();

                $modelCoordinate->order_id = $model->id;
                $modelCoordinate->save();*/
            }

        }

    }

}
