<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ImageHandler
{
    public function saveBase64Image(string $base64Image, string $directory = ''): ?string
    {
        try {
            $imageParts = explode(';base64,', $base64Image);
            $imageTypeAux = explode('image/', $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);
            $fileName = uniqid() . '.' . $imageType;
            Storage::disk('local')->put("$directory/$fileName", $imageBase64);
            return $fileName;
        } catch (\Throwable $th) {
            Log::info('Error saving image: ' . $th->getMessage());
            // Handle the error as needed, e.g., log it or throw an exception
            return null;
        }
    }
    public function deleteImage(string $fileName, string $path = ''): void
    {
        Log::info('Deleting image: ' . $fileName);
        try {
            if (Storage::disk('local')->exists($path . '/' . $fileName)) {
                Storage::disk('local')->delete($path . '/' . $fileName);
            }
        } catch (\Throwable $th) {
            Log::info('Error deleting image: ' . $th->getMessage());
            // Handle the error as needed, e.g., log it or throw an exception
        }
    }
    public function getBase64Image(string $fileName, string $path = ''): ?string
    {
        try {
            $filePath = $path . '/' . $fileName;
            if (Storage::disk('local')->exists($filePath)) {
                $fileContent = Storage::disk('local')->get($filePath);
                $mimeType = Storage::disk('local')->mimeType($filePath);
                return 'data:' . $mimeType . ';base64,' . base64_encode($fileContent);
            }
            return null;
        } catch (\Throwable $th) {
            Log::info('Error retrieving image: ' . $th->getMessage());
            return null;
        }
    }
    public function existsFile(string $fileName, string $path = ''): bool
    {
        try {
            return Storage::disk('local')->exists($path . '/' . $fileName);
        } catch (\Throwable $th) {
            Log::info('Error checking file existence: ' . $th->getMessage());
            return false;
        }
    }
    public function downloadFile(string $fileName, string $path = ''): ?StreamedResponse
    {
        try {
            $filePath = $path . '/' . $fileName;
            if (Storage::disk('local')->exists($filePath)) {
                return Storage::disk('local')->download($filePath);
            }
            return null;
        } catch (\Throwable $th) {
            Log::info('Error downloading file: ' . $th->getMessage());
            return null;
        }
    }

    public function deleteFile(string $fileName, string $path = ''): void
    {
        try {
            $filePath = $path . '/' . $fileName;
            if (Storage::disk('local')->exists($filePath)) {
                Storage::disk('local')->delete($filePath);
            }
        } catch (\Throwable $th) {
            Log::info('Error deleting file: ' . $th->getMessage());
        }
    }
}
