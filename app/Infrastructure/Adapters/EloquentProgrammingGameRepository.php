<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\ProgrammingGame;
use App\Domain\Repositories\ProgrammingGameRepository;

class EloquentProgrammingGameRepository implements ProgrammingGameRepository
{

    public function createProgrammingGame(array $data): ProgrammingGame
    {
        return ProgrammingGame::create([
            'GameInstancesId' => $data['GameInstancesId'],
            'ProgrammerId' => $data['ProgrammerId'],
            'Name' => $data['Name'],
            'Activated' => $data['Activated'],
            'StartTime' => $data['StartTime'],
            'EndTime' => $data['EndTime'],
            'Attempts' => $data['Attempts'],
            'MaximumTime' => $data['MaximumTime'],
        ]);
    }

    public function deleteProgrammingGame(int $id): ProgrammingGame
    {
        $programmingGame = ProgrammingGame::findOrFail($id);
        $programmingGame->Activated = false;
        $programmingGame->save();
        return $programmingGame;
    }

    public function getAllProgrammingGames(int $limit = 6, int $offset = 0): array
    {
        // Obtener el total de registros sin paginación
        $total = ProgrammingGame::count();

        // Obtener los registros paginados
        $games = ProgrammingGame::skip($offset)
            ->take($limit)
            ->get()
            ->toArray();

        return [
            'total' => $total,   // cantidad total de registros
            'offset' => $offset, // offset actual
            'limit' => $limit,   // límite de registros por consulta
            'data' => $games     // registros solicitados
        ];
    }


    public function getProgrammingGameById(int $id): ProgrammingGame
    {
        $programmingGame = ProgrammingGame::find($id);

        if (!$programmingGame) {
            throw new \RuntimeException("Programming game not found with ID: $id");
        }

        return $programmingGame;
    }

    public function updateProgrammingGame(int $id, array $data): ProgrammingGame
    {
        $programmingGame = ProgrammingGame::find($id);

        if (!$programmingGame) {
            throw new \RuntimeException("Programming game not found with ID: $id");
        }
        $programmingGame->update([
            'GameInstancesId' => $data['GameInstancesId'],
            'ProgrammerId' => $data['ProgrammerId'],
            'Name' => $data['Name'],
            'Activated' => $data['Activated'],
            'StartTime' => $data['StartTime'],
            'EndTime' => $data['EndTime'],
            'Attempts' => $data['Attempts'],
            'MaximumTime' => $data['MaximumTime'],
        ]);
        return $programmingGame;
    }
}