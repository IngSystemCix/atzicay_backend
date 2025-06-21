<?php

namespace App\Utils;

class StorageUtility
{
    /**
     * Sube una o varias imágenes al servidor con validación, con opción de sobrescritura.
     *
     * @param string|array $sourcePaths Ruta(s) absoluta(s) de la(s) imagen(es) local(es).
     * @param string $destinationPath Carpeta destino absoluta (por ejemplo: D:/storage/memory).
     * @param string|null $fileName Nombre exacto del archivo (sin extensión) si deseas sobrescribir. Si es null, se genera uno nuevo con prefijo.
     * @param array $allowedFormats Formatos permitidos (por defecto: ['jpg', 'jpeg', 'png']).
     * @param string $prefix Prefijo para el nombre del archivo si $fileName es null.
     * @return array Resultado ['success' => [ruta_completa, ...], 'errors' => [mensaje, ...]]
     */
    public static function uploadImage($sourcePaths, string $destinationPath, ?string $fileName = null, array $allowedFormats = ['jpg', 'jpeg', 'png'], string $prefix = 'img_'): array
    {
        $results = [
            'success' => [],
            'errors' => []
        ];

        $files = is_array($sourcePaths) ? $sourcePaths : [$sourcePaths];

        if (!is_dir($destinationPath)) {
            if (!mkdir($destinationPath, 0777, true) && !is_dir($destinationPath)) {
                return ['errors' => ["Failed to create destination directory: $destinationPath"]];
            }
        }

        foreach ($files as $sourcePath) {
            if (!file_exists($sourcePath)) {
                $results['errors'][] = "Source file does not exist: $sourcePath";
                continue;
            }

            $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
            if (!in_array($extension, $allowedFormats)) {
                $results['errors'][] = "Invalid file format for file $sourcePath. Allowed formats: " . implode(', ', $allowedFormats);
                continue;
            }

            // Si se especifica un nombre de archivo fijo, usarlo
            if ($fileName !== null) {
                $newFileName = $fileName . '.' . $extension; // usa mismo nombre (para overwrite)
            } else {
                // Genera un nombre único si no se especificó
                $dateTime = date('Ymd_His');
                $newFileName = $prefix . uniqid('_', true) . '_' . $dateTime . '.' . $extension;
            }

            $targetPath = rtrim($destinationPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newFileName;

            if (!copy($sourcePath, $targetPath)) {
                $results['errors'][] = "Failed to copy file: $sourcePath";
                continue;
            }

            $results['success'][] = $targetPath;
        }

        return $results;
    }
}
