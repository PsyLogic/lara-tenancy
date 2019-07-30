<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class BannedException extends AccessDeniedHttpException
{
    
    
    public function __construct(string $message = null, \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($message, $previous, $code ,$headers);
    }
}
