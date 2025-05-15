<?php

namespace App\Application\UseCase\GameInstances;

use App\Domain\Repositories\GameInstancesRepository;
use Illuminate\Http\Request;

class SearchUseCase
{
    public function __construct(private GameInstancesRepository $repository) {}

    /**
     * Search for game instances based on given criteria.
     *
     * @param Request $request
     * @return array
     */
    public function execute(Request $request): array
    {
        $filters = $request->only(['name', 'author', 'type', 'difficulty']);
        $results = $this->repository->search($filters);

        return $results;
    }
}
