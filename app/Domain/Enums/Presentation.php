<?php
namespace App\Domain\Enums;

/**
 * Enum representing different presentation modes.
 */
enum Presentation: string {
    /**
     * Aleatory presentation mode.
     */
    case ALEATORY = "A";

    /**
     * Fixed presentation mode.
     */
    case FIXED = "F";
}