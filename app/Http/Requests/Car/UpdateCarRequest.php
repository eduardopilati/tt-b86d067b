<?php

namespace App\Http\Requests\Car;

use App\Rules\Plate;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'model' => [
                'required',
                'string',
            ],
            'brand' => [
                'required',
                'string',
            ],
            'plate' => [
                'required',
                'string',
                new Plate(),
                Rule::unique('cars')->ignore($this->route('car')),
            ],
            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . Carbon::now()->year,
            ],
        ];
    }
}
