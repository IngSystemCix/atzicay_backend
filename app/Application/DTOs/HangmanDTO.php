<?php

namespace App\Application\DTOs;

class HangmanDTO
{
    public function __construct(
        public int $gameInstanceId,
        public string $word,
        public string $clue,
        public string $presentation,
    ){}
}
