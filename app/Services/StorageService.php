<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function upload(
        UploadedFile $file,
        string $folder = 'uploads',
        string $disk = 'public'
    ): string {

        return $file->store($folder, $disk);

    }

    public function delete(
        ?string $path,
        string $disk = 'public'
    ): void {

        if ($path && Storage::disk($disk)->exists($path)) {

            Storage::disk($disk)->delete($path);

        }

    }

    public function replace(
        UploadedFile $file,
        ?string $oldPath,
        string $folder = 'uploads',
        string $disk = 'public'
    ): string {

        $this->delete($oldPath, $disk);

        return $this->upload($file, $folder, $disk);

    }
}