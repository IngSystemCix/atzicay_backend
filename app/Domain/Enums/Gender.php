<?php

namespace App\Domain\Enums;

enum Gender: string {
    case MALE = "M";
    case FEMALE = "F";
    case OTHER = "O";
}