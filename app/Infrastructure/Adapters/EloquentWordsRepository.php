<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Words;
use App\Domain\Repositories\WordsRepository;

class EloquentWordsRepository implements WordsRepository {

    public function createWord(array $data): Words {
        return Words::create([
            'SolveTheWordId' => $data['SolveTheWordId'],
            'Word' => $data['Word'],
            'Orientation'=> $data['Orientation'],
        ]);
    }
    
    public function getWordById(int $id): Words {
        $words = Words::find($id);
        if (!$words) {
            throw new \RuntimeException("Word not found with ID: $id");
        }
        return $words;
    }

    public function updateWord(int $id, array $data): Words {
        $words = Words::find($id);
        if (!$words) {
            throw new \RuntimeException("Word not found with ID: $id");
        }
        $words->update([
            'SolveTheWordId' => $data['SolveTheWordId'],
            'Word' => $data['Word'],
            'Orientation'=> $data['Orientation'],
        ]);
        return $words;
    }
}