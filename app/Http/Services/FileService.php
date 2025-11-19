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
    public function deleteFile(string $filePath, string $folderName='uploads'): bool
    {
        if(!File::exists(public_path($filePath))){
            throw new \Exception('File does not exists');
        }
        return File::delete(public_path($filePath));
    }
}
