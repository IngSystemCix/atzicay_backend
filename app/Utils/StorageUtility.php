<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StorageUtility
{
    public static function uploadImage($source, string $destinationPath, ?string $fileName = null, array $allowedFormats = ['jpg', 'jpeg', 'png'], string $prefix = 'img_'): array
    {
        Log::info('StorageUtility::uploadImage called', [
            'source_type' => gettype($source),
            'source_sample' => is_string($source) ? substr($source, 0, 100) : 'not_string',
            'destination' => $destinationPath,
            'fileName' => $fileName,
            'prefix' => $prefix
        ]);

        $results = [
            'success' => [],
            'errors' => []
        ];

        // Limpiar la ruta de destino para evitar concatenaciones incorrectas
        $cleanDestinationPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $destinationPath);

        // Si la ruta no es absoluta, convertirla a absoluta
        if (!preg_match('/^[A-Za-z]:/', $cleanDestinationPath) && !str_starts_with($cleanDestinationPath, '/')) {
            $cleanDestinationPath = storage_path('app/public/' . $cleanDestinationPath);
        }

        Log::info('StorageUtility::uploadImage - Ruta limpiada', [
            'original' => $destinationPath,
            'cleaned' => $cleanDestinationPath
        ]);

        // Crear directorio si no existe
        if (!is_dir($cleanDestinationPath)) {
            Log::info('StorageUtility::uploadImage - Creando directorio', ['path' => $cleanDestinationPath]);

            if (!mkdir($cleanDestinationPath, 0777, true) && !is_dir($cleanDestinationPath)) {
                $error = "Unable to create directory at $cleanDestinationPath";
                Log::error('StorageUtility::uploadImage - Error creando directorio', ['error' => $error]);
                return ['errors' => [$error]];
            }

            Log::info('StorageUtility::uploadImage - Directorio creado exitosamente');
        }

        try {
            // Verificar si es una imagen base64
            if (is_string($source) && str_starts_with($source, 'data:image/')) {
                // Procesar imagen base64
                $data = explode(',', $source);
                if (count($data) !== 2) {
                    throw new \Exception('Invalid base64 image format');
                }

                $imageData = base64_decode($data[1]);
                if ($imageData === false) {
                    throw new \Exception('Failed to decode base64 image');
                }

                // Extraer extensión del tipo MIME
                preg_match('/data:image\/([a-zA-Z0-9]+);base64,/', $source, $matches);
                $extension = isset($matches[1]) ? strtolower($matches[1]) : 'jpg';

                // Validar formato
                if (!in_array($extension, $allowedFormats)) {
                    throw new \Exception("Invalid image format: $extension. Allowed formats: " . implode(', ', $allowedFormats));
                }

                // Generar nombre de archivo
                if ($fileName !== null) {
                    $newFileName = $fileName . '.' . $extension;
                } else {
                    $dateTime = date('Ymd_His');
                    $newFileName = $prefix . uniqid('_', true) . '_' . $dateTime . '.' . $extension;
                }

                $targetPath = rtrim($cleanDestinationPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newFileName;

                Log::info('StorageUtility::uploadImage - Guardando archivo', [
                    'targetPath' => $targetPath,
                    'imageSize' => strlen($imageData)
                ]);

                // Guardar imagen
                if (file_put_contents($targetPath, $imageData) === false) {
                    throw new \Exception("Failed to save image to: $targetPath");
                }

                Log::info('StorageUtility::uploadImage - Archivo guardado exitosamente', ['path' => $targetPath]);
                $results['success'][] = $targetPath;

            } else if (is_string($source) && file_exists($source)) {
                // Procesar archivo local (código original)
                $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));
                if (!in_array($extension, $allowedFormats)) {
                    throw new \Exception("Invalid file format for file $source. Allowed formats: " . implode(', ', $allowedFormats));
                }

                if ($fileName !== null) {
                    $newFileName = $fileName . '.' . $extension;
                } else {
                    $dateTime = date('Ymd_His');
                    $newFileName = $prefix . uniqid('_', true) . '_' . $dateTime . '.' . $extension;
                }

                $targetPath = rtrim($cleanDestinationPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newFileName;

                if (!copy($source, $targetPath)) {
                    throw new \Exception("Failed to copy file: $source");
                }

                $results['success'][] = $targetPath;

            } else {
                throw new \Exception("Invalid source: must be a valid file path or base64 image string");
            }

        } catch (\Exception $e) {
            Log::error('StorageUtility::uploadImage exception', ['error' => $e->getMessage()]);
            $results['errors'][] = $e->getMessage();
        }

        return $results;
    }
}
