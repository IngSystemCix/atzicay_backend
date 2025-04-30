<?php

namespace App\Domain\Enums;

/**
 * Enum representing difficulty levels.
 */
enum Difficulty: string
{
    /**
     * Easy difficulty level.
     */
    case Easy = 'E';

    /**
     * Medium difficulty level.
     */
    case Medium = 'M';

    /**
     * Hard difficulty level.
     */
    case Hard = 'H';
}