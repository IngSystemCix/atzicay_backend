<?php
namespace App\Application\UseCase\Words;

use App\Domain\Entities\Words;
use App\Domain\Repositories\WordsRepository;

class GetWordByIdUseCase {
    public function __construct(
        private WordsRepository $repository
    ) {}

    public function execute(int $id): Words {
        $word = $this->repository->getWordById($id);
        if (!$word) {
            throw new \RuntimeException("Word not found for ID: $id");
        }
        return $word;
    }
}