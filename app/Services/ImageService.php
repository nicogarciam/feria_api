<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    public function upload(UploadedFile $file, ?string $type = 'product'): string
    {

        // Generar nombre único
        $filename = $this->generateFileName($file);

        // Path final
        $path = $type;

        // Guardar en disco (public por defecto)
        $storedPath = $file->storeAs($path, $filename, 'public');

        return 'storage/'. $storedPath;
    }

    public function delete(string $path): bool
    {
        if (!$path) {
            return false;
        }

        // Seguridad básica (evitar cosas raras tipo ../)
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
}
