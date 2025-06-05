<?php

namespace App\Domain\Services;

class UploadFileServices {

    private $base_path;
    private $valid_folders = ['memory_game', 'puzzles'];

    public function __construct() {
        $this->base_path = getenv('PATH_UPLOAD_FILES') ?: __DIR__;
        $this->create_folders();
    }

    private function create_folders() {
        foreach ($this->valid_folders as $folder) {
            $path = $this->base_path . DIRECTORY_SEPARATOR . $folder;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
        }
    }

    public function upload_multiple($files, $game_type, $id) {
        $results = [];

        // Normalizar el tipo de juego a snake_case
        $game_type = strtolower(trim($game_type));
        $game_type = str_replace([' ', '-'], '_', $game_type);

        if (!in_array($game_type, $this->valid_folders)) {
            return [['success' => false, 'message' => 'Tipo de juego no válido']];
        }

        $allowed_types = ['image/jpeg', 'image/png'];
        $max_size = 1 * 1024 * 1024;

        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $results[] = ['success' => false, 'message' => "Error al subir archivo $i"];
                continue;
            }

            if (!in_array($files['type'][$i], $allowed_types)) {
                $results[] = ['success' => false, 'message' => "Archivo $i no es JPG o PNG"];
                continue;
            }

            if ($files['size'][$i] > $max_size) {
                $results[] = ['success' => false, 'message' => "Archivo $i excede 1MB"];
                continue;
            }

            $original_name = pathinfo($files['name'][$i], PATHINFO_FILENAME);
            $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $snake_name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $original_name));
            $file_name = $id . '_' . $snake_name . '.' . $extension;

            $destination = $this->base_path . DIRECTORY_SEPARATOR . $game_type . DIRECTORY_SEPARATOR . $file_name;

            if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                $results[] = [
                    'success' => true,
                    'message' => "Archivo $i subido correctamente",
                    'path' => $destination,
                    'file' => $file_name
                ];
            } else {
                $results[] = ['success' => false, 'message' => "Error al guardar archivo $i"];
            }
        }

        return $results;
    }
}
