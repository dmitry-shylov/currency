<?php declare(strict_types=1);

namespace App\Exception;

class GetParameterWrongException extends \Exception implements PublicException
{
    /**
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message, $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
