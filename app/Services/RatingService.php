<?php

namespace App\Services;

use App\Models\Assessment;
use Illuminate\Support\Facades\Log;

class RatingService
{
    public function valueRating(int $gameInstanceId, int $userId, int $value, string $comments = null): string
    {
        try {
            // Verificar si ya existe una valoración del usuario para el juego
            $existing = Assessment::where('GameInstanceId', $gameInstanceId)
                ->where('UserId', $userId)
                ->first();

            if ($existing) {
                // Actualizar la valoración existente
                $existing->Value = $value;
                $existing->Comments = $comments;
                $existing->Activated = true;
                $existing->save();

                return 'Rating updated successfully';
            }

            // Crear nueva valoración con Activated=true por defecto
            Assessment::create([
                'GameInstanceId' => $gameInstanceId,
                'UserId' => $userId,
                'Value' => $value,
                'Comments' => $comments,
                'Activated' => true,
            ]);

            return 'Rating created successfully';
        } catch (\Exception $e) {
            Log::error('[RatingService][valueRating] Error:', [
                'error' => $e->getMessage(),
                'GameInstanceId' => $gameInstanceId,
                'UserId' => $userId,
                'Value' => $value,
                'Comments' => $comments,
            ]);
            return 'Error processing rating: ' . $e->getMessage();
        }
    }
}
