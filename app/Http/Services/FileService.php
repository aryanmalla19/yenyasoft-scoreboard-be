<?php

declare(strict_types=1);

namespace App\Http\Services;

use Illuminate\Support\Facades\File;

class FileService
{
    /**
     * @throws \Exception
     */
    public function uploadFile(string $fileName, string $folderName='uploads'): string
    {
        if(!request()->hasFile($fileName)){
            throw new \Exception('File does not exists');
        }
        return request()->file($fileName)->store($folderName, 'public');
    }

    /**
     * @throws \Exception
     */
    public function deleteFile(string $filePath): bool
    {
        if(!File::exists(public_path('/storage/'.$filePath))){
            throw new \Exception(public_path('/'.$filePath));
        }
        return File::delete(public_path('/storage/'.$filePath));
    }
}
