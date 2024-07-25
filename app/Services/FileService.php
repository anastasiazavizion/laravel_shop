<?php

namespace App\Services;

use App\Services\Contracts\FileServiceContract;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService implements FileServiceContract
{
    public function upload(string|UploadedFile $file = '', $additionalPath  = ''): string
    {
        if(empty($file)){
            return $file;
        }
        if(is_string($file)){
            return str_replace('public/storage', '', $file);
        }

        if($file->getSize() < 91){
            throw new \Exception('File is too small');
        }

        if(is_array($additionalPath)){
            $additionalPath = implode('/', $additionalPath).'/';
        }else{
            $additionalPath = str_replace('//','/',!empty($additionalPath) ? $additionalPath.'/' : '');
        }
        $filePath = $additionalPath .time(). '_'.Str::random(5).'_'.$file->getClientOriginalName();
        Storage::put($filePath, File::get($file));
        Storage::setVisibility($filePath, 'public');
        return  $filePath;
    }

    public function remove(string $filePath):void
    {
        Storage::delete($filePath);
    }
}
