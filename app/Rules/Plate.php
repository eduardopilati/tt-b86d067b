<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Plate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = strtoupper($value);

        if (!preg_match('/^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/', $value)) {
            $fail("O campo $attribute informado não é uma placa válida.");
        }
    }
}
