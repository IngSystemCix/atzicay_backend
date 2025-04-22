<?php

namespace App\Application\DTOs\Assessment;

class CreateAssessmentDTO
{
    public function __construct(
        public bool $activated,
        public int $gameInstanceId,
        public int $userId,
        public int $value,
        public ?string $comments = null
    ) {}
}