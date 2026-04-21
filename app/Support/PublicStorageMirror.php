<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PublicStorageMirror
{
    public static function put(string $path, string $contents): void
    {
        $target = self::targetPath($path);

        File::ensureDirectoryExists(dirname($target));
        File::put($target, $contents);
    }

    public static function copyFromPublicDisk(string $path): void
    {
        if (! Storage::disk('public')->exists($path)) {
            return;
        }

        self::put($path, Storage::disk('public')->get($path));
    }

    public static function delete(string $path): void
    {
        $target = self::targetPath($path);

        if (File::exists($target)) {
            File::delete($target);
        }
    }

    private static function targetPath(string $path): string
    {
        $basePath = rtrim((string) env('PUBLIC_STORAGE_PATH', public_path('storage')), DIRECTORY_SEPARATOR . '/\\');
        $cleanPath = ltrim(str_replace(['../', '..\\'], '', $path), '/\\');

        return $basePath . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $cleanPath);
    }
}
