<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Hangman;
use App\Domain\Repositories\HangmanRepository;
use DB;

class EloquentHangmanRepository implements HangmanRepository
{
    public function createHangman(array $data): Hangman
    {
        return Hangman::create([
            "GameInstanceId" => $data["GameInstanceId"],
            "Word" => $data["Word"],
            "Clue" => $data["Clue"],
            "Presentation" => $data["Presentation"],
        ]);
    }

    public function getAllHangman(): array
    {
        // Obtener el menor Id por cada GameInstanceId
        $subquery = DB::table('Hangman')
            ->select(DB::raw('MIN(Id) as min_id'))
            ->groupBy('GameInstanceId');

        // Luego obtener los registros que coinciden con esos Ids
        return Hangman::query()
            ->whereIn('Id', function ($query) use ($subquery) {
                $query->select('min_id')->fromSub($subquery, 'sub');
            })
            ->get()
            ->toArray();
    }


    public function getHangmanById(int $id): Hangman
    {
        $hangman = Hangman::find($id);

        if (!$hangman) {
            throw new \RuntimeException("Hangman not found with ID: $id");
        }

        return $hangman;
    }

    public function updateHangman(int $id, array $data): Hangman
    {
        $hangman = Hangman::find($id);

        if (!$hangman) {
            throw new \RuntimeException("Hangman not found with ID: $id");
        }
        $hangman->update([
            "GameInstanceId" => $data["GameInstanceId"],
            "Word" => $data["Word"],
            "Clue" => $data["Clue"],
            "Presentation" => $data["Presentation"],
        ]);
        return $hangman;
    }
}