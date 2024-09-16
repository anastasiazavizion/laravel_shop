<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contract\ImageRepositoryContract;
use App\Services\Contracts\FileServiceContract;
use Illuminate\Database\Eloquent\Model;

class ImageRepository implements  ImageRepositoryContract
{
    /**
     * @throws \Exception
     */
    public function attach(Model $model, string $relation, array $images = [], ?string $directory = null): void
    {
        if(!method_exists($model, $relation)){
            throw new \Exception($model::class, "Model $model doesn't have relation $relation");
        }else{

           if (!empty($images)) {
                foreach($images as $image) {
                    call_user_func([$model, $relation])->create([
                        'path' => compact('image', 'directory')
                    ]);
                }
            }
        }
    }

    public function detach(Model $model, string $relation, array $images = []): void
    {
        if(!method_exists($model, $relation)){
            throw new \Exception($model::class, "Model $model doesn't have relation $relation");
        }else{
            $query = call_user_func([$model, $relation]);

            $query->when(!empty($images), function ($query) use ($images) {
                $query->whereIn('id', $images);
            });

            $query->get()->map(function ($item){
                $item->delete();
            });
        }
    }
}
