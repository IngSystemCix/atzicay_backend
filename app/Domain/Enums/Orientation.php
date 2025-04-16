<?php
namespace App\Domain\Enums;

enum Orientation: string
{
    case HORIZONTAL_LEFT = "HL";
    case HORIZONTAL_RIGHT = "HR";
    case VERTICAL_UP = "VU";
    case VERTICAL_DOWN = "VD";
    case DIAGONAL_UP = "DU";
    case DIAGONAL_DOWN = "DD";
}