<?php

namespace Tests\Unit\Services;

use App\Services\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileServiceTest extends TestCase
{
    protected FileServiceContract $service;
    private const FILE_NAME = 'image.png';
    private const STORAGE_TYPE = 'public';

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(FileServiceContract::class);
        Storage::fake(self::STORAGE_TYPE);
    }

    public function uploadedFile($additionalPath = '') : string
    {
        $file = UploadedFile::fake()->image(self::FILE_NAME);
        return $this->service->upload($file, $additionalPath);
    }
    /**
     * A basic unit test example.
     */
    public function test_success_with_the_valid_file(): void
    {
        $uploadedFile = $this->uploadedFile();
        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertEquals(self::STORAGE_TYPE, Storage::getVisibility($uploadedFile));
    }

    public function test_error_with_small_file(): void
    {
        $file = UploadedFile::fake()->image(self::FILE_NAME, 1, 1);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File is too small');
        $this->service->upload($file);
    }

    public function test_success_with_the_valid_file_and_additional_path(): void
    {
        $folder = 'test';
        $this->assertFalse(Storage::directoryExists($folder));
        $uploadedFile = $this->uploadedFile($folder);
        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertTrue(Storage::directoryExists($folder));
        $this->assertEquals('public', Storage::getVisibility($uploadedFile));
    }

    public function test_remove_file()
    {
        $uploadedFile = $this->uploadedFile();
        $this->assertTrue(Storage::has($uploadedFile));
        $this->service->remove($uploadedFile);
        $this->assertFalse(Storage::has($uploadedFile));
    }

    public function test_it_returns_the_same_path_for_string_file()
    {
        $fileName = 'test.png';
        $newFileName = $this->service->upload($fileName);
        $this->assertEquals($fileName,$newFileName);
    }

    public function test_success_with_additional_path_is_array()
    {
        $folder = 'folder';
        $subfolder = 'subfolder';
        $this->assertFalse(Storage::directoryExists($folder));
        $this->assertFalse(Storage::directoryExists("$folder/$subfolder"));
        $uploadedFile = $this->uploadedFile([$folder,$subfolder]);
        $this->assertTrue(Storage::directoryExists($folder));
        $this->assertTrue(Storage::directoryExists("$folder/$subfolder"));
        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertEquals(self::STORAGE_TYPE, Storage::getVisibility($uploadedFile));
    }

    public function test_success_with_additional_path_is_number()
    {
        $folder = 12345;
        $this->assertFalse(Storage::directoryExists($folder));
        $uploadedFile = $this->uploadedFile($folder);
        $this->assertTrue(Storage::directoryExists($folder));
        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertEquals(self::STORAGE_TYPE, Storage::getVisibility($uploadedFile));
    }

    public function test_success__additional_path_is_slash()
    {
        $folder = '/';
        $this->assertTrue(Storage::directoryExists($folder));
        $uploadedFile = $this->uploadedFile($folder);
        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertEquals(self::STORAGE_TYPE, Storage::getVisibility($uploadedFile));
    }

}
