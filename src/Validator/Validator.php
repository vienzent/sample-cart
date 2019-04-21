<?php declare(strict_types=1);

namespace App\Validator;

use App\Contracts\Validator\ValidatorInterface;
use App\Contracts\Validator\ValidatorException;

class Validator implements ValidatorInterface
{
    protected $validator = null;

    public function __construct(\GUMP $validator) // TODO: create adapter
    {
        $this->validator = $validator;
    }

    public function validate(array $data, array $rules) : array
    {

        $data = $this->validator->sanitize($data);

        $this->validator->validation_rules($rules);

        if ($this->validator->run($data) === false) {
            throw new ValidatorException($data, $this->validator->get_readable_errors() , "Validation Error!");
        } else {
            return $data;
        }
    }
}