<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Words;

interface WordsRepository {
    public function getWordById(int $id): Words;
    public function createWord(array $data): Words;
    public function updateWord(int $id, array $data): Words;
}