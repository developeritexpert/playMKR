<?php
namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadHelper
{
    public static function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $path = $folder.'/images';

        } elseif (in_array($extension, ['mp4', 'mov', 'avi', 'webm'])) {
            $path = $folder.'/videos';
        } else {
            $path = $folder.'/documents';
        }

        $fileName = time().'_'.Str::random(10).'.'.$extension;
        return $file->storeAs($path, $fileName, 'public');
    }

    public static function delete(?string $filePath): void
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}


