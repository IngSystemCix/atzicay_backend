<?php

namespace App\Services;

use App\Models\GameInstance;
use App\Models\ProgrammingGame;
use Illuminate\Support\Facades\DB;

class ProgrammingService
{
    public function myProgrammingGames(
        ?string $startDate,
        ?string $endDate,
        ?string $exactStartDate,
        ?string $exactEndDate,
        int $userId,
        string $gameType,
        int $limit = 10,
        int $offset = 0
    ): array {
        // Query base compartida
        $baseQuery = GameInstance::query()
            ->join('users', 'users.Id', '=', 'gameinstances.ProfessorId')
            ->leftJoin('programminggame', 'programminggame.GameInstancesId', '=', 'gameinstances.Id')
            ->leftJoin('hangman', 'hangman.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('memorygame', 'memorygame.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('puzzle', 'puzzle.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('solvetheword', 'solvetheword.GameInstanceId', '=', 'gameinstances.Id')
            ->where('users.Id', $userId)
            ->whereNotNull('programminggame.Name')
            // Filtro por tipo de juego
            ->when($gameType !== 'all', function ($query) use ($gameType) {
                $query->where(DB::raw("CASE
                WHEN hangman.GameInstanceId IS NOT NULL THEN 'hangman'
                WHEN memorygame.GameInstanceId IS NOT NULL THEN 'memory'
                WHEN puzzle.GameInstanceId IS NOT NULL THEN 'puzzle'
                WHEN solvetheword.GameInstanceId IS NOT NULL THEN 'solve_the_word'
                ELSE 'unknown'
            END"), '=', $gameType);
            })
            // Filtro por fecha exacta de inicio
            ->when($exactStartDate, function ($query) use ($exactStartDate) {
                $query->whereDate('programminggame.StartTime', $exactStartDate);
            })
            // Filtro por fecha exacta de fin
            ->when($exactEndDate, function ($query) use ($exactEndDate) {
                $query->whereDate('programminggame.EndTime', $exactEndDate);
            })
            // Filtro por rango de fechas de inicio
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('programminggame.StartTime', [$startDate, $endDate]);
            })
            ->when($startDate && !$endDate, function ($query) use ($startDate) {
                $query->whereDate('programminggame.StartTime', '>=', $startDate);
            })
            ->when(!$startDate && $endDate, function ($query) use ($endDate) {
                $query->whereDate('programminggame.StartTime', '<=', $endDate);
            });

        // Total de resultados SIN limit ni offset
        $total = $baseQuery->count(DB::raw('DISTINCT gameinstances.Id'));

        // Clonar query para datos paginados
        $data = (clone $baseQuery)
            ->select([
                'gameinstances.Id AS game_instance_id',
                'programminggame.Name AS programming_name',
                DB::raw("CASE
                WHEN hangman.GameInstanceId IS NOT NULL THEN 'hangman'
                WHEN memorygame.GameInstanceId IS NOT NULL THEN 'memory'
                WHEN puzzle.GameInstanceId IS NOT NULL THEN 'puzzle'
                WHEN solvetheword.GameInstanceId IS NOT NULL THEN 'solve_the_word'
                ELSE 'unknown'
            END AS type_game"),
                'gameinstances.Name AS name_game',
                'programminggame.StartTime AS start_time',
                'programminggame.EndTime AS end_time',
                'programminggame.Attempts AS attempts',
                'programminggame.MaximumTime AS maximum_time',
                'programminggame.Activated AS status'
            ])
            ->groupBy(
                'gameinstances.Id',
                'programminggame.Name',
                'gameinstances.Name',
                'programminggame.StartTime',
                'programminggame.EndTime',
                'programminggame.Attempts',
                'programminggame.MaximumTime',
                'programminggame.Activated',
                'hangman.GameInstanceId',
                'memorygame.GameInstanceId',
                'puzzle.GameInstanceId',
                'solvetheword.GameInstanceId'
            )
            ->limit($limit)
            ->offset($offset)
            ->get()
            ->toArray();

        return [
            'total' => $total,
            'data' => $data,
        ];
    }

    public function disableProgrammingGame(int $gameInstanceId): string
    {
        // Buscar la instancia de ProgrammingGame por su GameInstanceId
        $programmingGame = ProgrammingGame::where('GameInstancesId', $gameInstanceId)->first();

        // Verificar si existe
        if (!$programmingGame) {
            return 'Programming game not found for this game instance';
        }

        // Cambiar el estado a deshabilitado (suponiendo que 0 significa deshabilitado)
        $programmingGame->Activated = 0;
        $programmingGame->save();

        return 'Programming game disabled successfully';
    }
    public function createProgrammingGame(int $gameInstanceId, int $userId, array $data): string
    {
        if (ProgrammingGame::where('GameInstancesId', $gameInstanceId)->exists()) {
            return 'A programming game already exists for this game instance';
        }
        
        $programmingGame = new ProgrammingGame();
        $programmingGame->GameInstancesId = $gameInstanceId;
        $programmingGame->ProgrammerId = $userId;
        $programmingGame->Name = $data['Name'] ?? null;
        $programmingGame->Activated = $data['Activated'] ?? 1;
        $programmingGame->StartTime = $data['StartTime'] ?? null;
        $programmingGame->EndTime = $data['EndTime'] ?? null;
        $programmingGame->Attempts = $data['Attempts'] ?? 3;
        $programmingGame->MaximumTime = $data['MaximumTime'] ?? 0;

        $programmingGame->save();

        return 'Programming game created successfully';
    }

}