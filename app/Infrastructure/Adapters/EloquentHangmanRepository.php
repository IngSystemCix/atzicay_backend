<?php

namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Hangman;
use App\Domain\Repositories\HangmanRepository;

class EloquentHangmanRepository implements HangmanRepository
{
    public function createHangman(array $data): Hangman {
        return Hangman::create($data);
    }
    public function getHangmanById(int $id): Hangman {
        return Hangman::find($id);
    }
    public function getAllHangman(): Array {
        return array_map(function (Hangman $hangman) {
            return $hangman->toArray();
        }, Hangman::all()->toArray());
    }
    public function updateHangman(int $id, array $data): Hangman{
        $hagman = Hangman::find($id);
        if($hagman){
            $hagman->update($data);
        }
        return $hagman;
    }
    public function deleteHangman(int $id): Hangman {
        $hagman = Hangman::find($id);
        if($hagman){
            $hagman->delete();
        }
        return $hagman;
    }    
}