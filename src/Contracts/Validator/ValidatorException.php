<?php declare(strict_types=1);

namespace App\Contracts\Validator;

use Exception;
use Throwable;

class ValidatorException extends Exception
{
    protected $data = [];
    protected $errors = [];

    public function __construct(array $data, array $errors ,string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function getErrors() : array
    {
        return $this->errors;
    }
}
