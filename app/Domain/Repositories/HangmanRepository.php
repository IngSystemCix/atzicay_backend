<?php
namespace App\Domain\Repositories;
use app\Domain\Entities\Hangman;

interface HangmanRepository
{
    public function createHangman (array $data): Hangman;
    public function getById (int $id): Hangman;
    public function getAll(): Collection;
    public function findByGameInstanceId(int $gameInstanceId): Collection;
    public function updateHangman(int $id, array $data): Hangman;
    public function deleteHangman(int $id): Hangman;
    public function updatePresentationHangman(int $id, string $presentation): Hangman;

}