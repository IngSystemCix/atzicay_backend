<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected array $extra;
    
    public function __construct(int $code, array $extra = [])
    {
        $this->extra = $extra;
        parent::__construct('', $code);
    }

    public function getExtra(): array
    {
        return $this->extra;
    }
}
