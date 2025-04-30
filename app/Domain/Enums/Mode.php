<?php

namespace App\Domain\Enums;

/**
 * Enum representing different operational modes.
 */
enum Mode: string {
    /**
     * Mode for converting an image to another image.
     */
    case IMAGE_TO_IMAGE = "II";

    /**
     * Mode for converting an image to a description.
     */
    case IMAGE_TO_DESCRIPTION = "ID";
}