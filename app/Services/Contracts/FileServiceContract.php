<?php
namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;

interface FileServiceContract
{
    public function upload(string|UploadedFile $file, $additionalPath  = '');

    public function remove(string $filePath):void;

    public function url(string $path, string $key): string;
}
