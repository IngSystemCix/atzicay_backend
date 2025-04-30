<?php
namespace App\Application\UseCase\Words;

use App\Application\DTOs\WordsDTO;
use App\Application\Mappers\WordsMapper;
use App\Domain\Entities\Words;
use App\Domain\Repositories\WordsRepository;

class CreateWordUseCase {
    public function __construct(
        private WordsRepository $repository,
    ) {}

    public function execute(WordsDTO $dto): Words {
        $word = WordsMapper::toEntity($dto);
        $this->repository->createWord(WordsMapper::toArray($word));
        return $word;
    }
}