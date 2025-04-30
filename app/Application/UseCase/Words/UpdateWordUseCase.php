<?php
namespace App\Application\UseCase\Words;

use App\Application\DTOs\WordsDTO;
use App\Application\Mappers\WordsMapper;
use App\Domain\Entities\Words;
use App\Domain\Repositories\WordsRepository;

class UpdateWordUseCase {
    public function __construct(
        private WordsRepository $repository,
    ) {}

    public function execute($id, WordsDTO $dto): Words {
        $word = $this->repository->getWordById($id);
        if (! $word) {
            throw new \RuntimeException("Word not found for ID: $id");
        }
        $updateWord = WordsMapper::toEntity($dto);
        return $this->repository->updateWord($id, WordsMapper::toArray($updateWord));
    }
}