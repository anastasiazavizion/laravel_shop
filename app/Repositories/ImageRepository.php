<?php

namespace App\Repositories;

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

    public function detach(Model $model, string $relation): void
    {
        if(!method_exists($model, $relation)){
            throw new \Exception($model::class, "Model $model doesn't have relation $relation");
        }else{
            $fileService = app(FileServiceContract::class);
            call_user_func([$model, $relation])->get()->map(function ($item) use ($fileService){
                $fileService->remove($item->path);
                $item->delete();
            });
        }
    }
}
