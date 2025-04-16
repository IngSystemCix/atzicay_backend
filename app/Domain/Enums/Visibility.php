<?php
namespace App\Domain\Enums;

enum Visibility: string {
    case PUBLIC = "P";
    case PRIVATE = "R";
}