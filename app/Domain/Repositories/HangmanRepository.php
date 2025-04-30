<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Hangman;

interface HangmanRepository
{
    public function getAllHangman(): array;
    public function getHangmanById(int $id): Hangman;
    public function createHangman(array $data): Hangman;
    public function updateHangman(int $id, array $data): Hangman;
}