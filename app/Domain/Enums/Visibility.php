<?php
namespace App\Domain\Enums;

/**
 * Enum representing visibility options.
 */
enum Visibility: string {
    /**
     * Public visibility.
     */
    case PUBLIC = "P";

    /**
     * Private visibility.
     */
    case PRIVATE = "R";
}