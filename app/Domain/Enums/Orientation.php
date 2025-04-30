<?php

namespace App\Domain\Enums;

/**
 * Enum representing different orientations.
 */
enum Orientation: string
{
    /**
     * Horizontal orientation to the left.
     */
    case HORIZONTAL_LEFT = "HL";

    /**
     * Horizontal orientation to the right.
     */
    case HORIZONTAL_RIGHT = "HR";

    /**
     * Vertical orientation upwards.
     */
    case VERTICAL_UP = "VU";

    /**
     * Vertical orientation downwards.
     */
    case VERTICAL_DOWN = "VD";

    /**
     * Diagonal orientation upwards.
     */
    case DIAGONAL_UP = "DU";

    /**
     * Diagonal orientation downwards.
     */
    case DIAGONAL_DOWN = "DD";
}