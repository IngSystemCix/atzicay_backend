<?php

namespace App\Domain\Enums;

/**
 * Enum representing gender options.
 */
enum Gender: string {
    /**
     * Male gender.
     */
    case MALE = "M";

    /**
     * Female gender.
     */
    case FEMALE = "F";

    /**
     * Other gender.
     */
    case OTHER = "O";
}