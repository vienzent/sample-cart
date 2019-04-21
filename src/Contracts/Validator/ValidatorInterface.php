<?php declare(strict_types=1);

namespace App\Contracts\Validator;


interface ValidatorInterface
{
    public function validate(array $data, array $rules) : array;
}