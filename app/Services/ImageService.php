<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    private const MAX_FILE_SIZE_BYTES = 2097152; // 2 MB
    private const MAX_DIMENSION = 900;
    private const JPEG_WEBP_QUALITY = 82;
    private const PNG_COMPRESSION = 8;

    public function upload(UploadedFile $file, ?string $type = 'product', $store = null): string
    {
        $filename = $this->generateFileName($file);
        $path = $type;
        if ($store !== null) {
            $path .= '/' . $this->buildStoreFolderName($store);
        }

        $storedPath = $path . '/' . $filename;

        $optimizedImage = $this->optimizeImageIfNeeded($file);
        if ($optimizedImage !== null) {
            Storage::disk('public')->put($storedPath, $optimizedImage);
        } else {
            $storedPath = $file->storeAs($path, $filename, 'public');
        }

        return 'storage/' . $storedPath;
    }

    public function moveFromGenericToStore(string $sourcePath, $store, string $type = 'stores'): ?string
    {
        $normalizedSourcePath = $this->normalizeStoragePath($sourcePath);
        if ($normalizedSourcePath === '' || str_contains($normalizedSourcePath, '..')) {
            return null;
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($normalizedSourcePath)) {
            return null;
        }

        $storeFolder = $this->buildStoreFolderName($store);
        $destinationDirectory = trim($type, '/') . '/' . $storeFolder;
        $destinationFilename = $this->buildDestinationFilename($normalizedSourcePath);
        $destinationPath = $destinationDirectory . '/' . $destinationFilename;

        if ($disk->exists($destinationPath)) {
            $extension = pathinfo($destinationFilename, PATHINFO_EXTENSION);
            $nameWithoutExtension = pathinfo($destinationFilename, PATHINFO_FILENAME);
            $destinationFilename = $nameWithoutExtension . '-' . Str::uuid() . ($extension ? '.' . $extension : '');
            $destinationPath = $destinationDirectory . '/' . $destinationFilename;
        }

        $disk->makeDirectory($destinationDirectory);
        if (!$disk->move($normalizedSourcePath, $destinationPath)) {
            return null;
        }

        return 'storage/' . $destinationPath;
    }

    private function buildStoreFolderName($store): string
    {
        $storeName = (string) ($store->name ?? 'store');
        $storeId = (string) ($store->id ?? '');
        $folderName = Str::slug(trim($storeName . ' ' . $storeId));

        if ($folderName === '') {
            return $storeId !== '' ? 'store-' . $storeId : 'store';
        }

        return $folderName;
    }

    private function normalizeStoragePath(string $path): string
    {
        $normalizedPath = trim($path);
        if ($normalizedPath === '') {
            return '';
        }

        if (filter_var($normalizedPath, FILTER_VALIDATE_URL)) {
            $normalizedPath = (string) parse_url($normalizedPath, PHP_URL_PATH);
        }

        $normalizedPath = ltrim($normalizedPath, '/');
        if (Str::startsWith($normalizedPath, 'storage/')) {
            $normalizedPath = Str::after($normalizedPath, 'storage/');
        }
        if (Str::startsWith($normalizedPath, 'public/')) {
            $normalizedPath = Str::after($normalizedPath, 'public/');
        }

        return $normalizedPath;
    }

    private function buildDestinationFilename(string $sourcePath): string
    {
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $originalName = pathinfo($sourcePath, PATHINFO_FILENAME);
        $sanitizedName = Str::slug($originalName);

        if ($sanitizedName === '') {
            $sanitizedName = 'image';
        }

        return $sanitizedName . ($extension ? '.' . strtolower($extension) : '');
    }

    public function delete(string $path): bool
    {
        if (!$path) {
            return false;
        }

        if (str_contains($path, '..')) {
            return false;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    private function generateFileName(UploadedFile $file): string
    {
        return Str::uuid() . '.' . $file->getClientOriginalExtension();
    }

    private function optimizeImageIfNeeded(UploadedFile $file): ?string
    {
        if (!extension_loaded('gd')) {
            return null;
        }

        $realPath = $file->getRealPath();
        if (!$realPath) {
            return null;
        }

        $sizeInfo = @getimagesize($realPath);
        if (!$sizeInfo || !isset($sizeInfo[0], $sizeInfo[1], $sizeInfo[2])) {
            return null;
        }

        [$width, $height, $imageType] = $sizeInfo;
        $currentSize = (int) ($file->getSize() ?? 0);
        $needsResize = $width > self::MAX_DIMENSION || $height > self::MAX_DIMENSION;
        $needsCompression = $currentSize > self::MAX_FILE_SIZE_BYTES || $needsResize;

        if (!$needsCompression) {
            return null;
        }

        $sourceImage = $this->createImageResource($realPath, $imageType);
        if (!$sourceImage) {
            return null;
        }

        $newWidth = $width;
        $newHeight = $height;
        if ($needsResize) {
            $ratio = min(self::MAX_DIMENSION / $width, self::MAX_DIMENSION / $height);
            $newWidth = max(1, (int) round($width * $ratio));
            $newHeight = max(1, (int) round($height * $ratio));
        }

        $targetImage = imagecreatetruecolor($newWidth, $newHeight);
        if (!$targetImage) {
            imagedestroy($sourceImage);
            return null;
        }

        $this->prepareCanvasTransparency($targetImage, $imageType);

        $resampled = imagecopyresampled(
            $targetImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );

        if (!$resampled) {
            imagedestroy($targetImage);
            imagedestroy($sourceImage);
            return null;
        }

        ob_start();
        $encoded = $this->encodeImageResource($targetImage, $imageType);
        $binary = $encoded ? ob_get_clean() : null;
        if (!$encoded) {
            ob_end_clean();
        }

        imagedestroy($targetImage);
        imagedestroy($sourceImage);

        return $binary;
    }

    private function createImageResource(string $path, int $imageType)
    {
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                return @imagecreatefromjpeg($path);
            case IMAGETYPE_PNG:
                return @imagecreatefrompng($path);
            case IMAGETYPE_GIF:
                return @imagecreatefromgif($path);
            case IMAGETYPE_WEBP:
                return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : null;
            default:
                return null;
        }
    }

    private function prepareCanvasTransparency($canvas, int $imageType): void
    {
        if (in_array($imageType, [IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP], true)) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, imagesx($canvas), imagesy($canvas), $transparent);
        }
    }

    private function encodeImageResource($image, int $imageType): bool
    {
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                return imagejpeg($image, null, self::JPEG_WEBP_QUALITY);
            case IMAGETYPE_PNG:
                return imagepng($image, null, self::PNG_COMPRESSION);
            case IMAGETYPE_GIF:
                return imagegif($image);
            case IMAGETYPE_WEBP:
                return function_exists('imagewebp')
                    ? imagewebp($image, null, self::JPEG_WEBP_QUALITY)
                    : false;
            default:
                return false;
        }
    }
}
