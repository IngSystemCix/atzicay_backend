<?php
namespace App\Domain\Enums;

enum Mode: string {
    case IMAGE_TO_IMAGE = "II";
    case IMAGE_TO_DESCRIPTION = "ID";
}