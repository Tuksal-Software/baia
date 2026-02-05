<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HandlesFileUploads
{
    /**
     * Upload file to public/uploads directory
     */
    protected function uploadFile(UploadedFile $file, string $folder): string
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path("uploads/{$folder}"), $filename);
        return "uploads/{$folder}/{$filename}";
    }

    /**
     * Delete file from public directory
     */
    protected function deleteFile(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            @unlink(public_path($path));
        }
    }

    /**
     * Check if file exists in public directory
     */
    protected function fileExists(?string $path): bool
    {
        return $path && file_exists(public_path($path));
    }
}
