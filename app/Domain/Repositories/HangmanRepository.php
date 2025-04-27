<?php
namespace App\Domain\Repositories;
use app\Domain\Entities\Hangman;

interface HangmanRepository
{
    public function createHangman (array $data): Hangman;
    public function getHangmanById (int $id): Hangman;
    public function getAllHangman(): array;
    public function updateHangman(int $id, array $data): Hangman;
    public function deleteHangman(int $id): Hangman;

}