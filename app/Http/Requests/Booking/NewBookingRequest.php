<?php

namespace App\Http\Requests\Booking;

use App\Classes\Validation\NoConflictBookingDates;
use Illuminate\Foundation\Http\FormRequest;

class NewBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'car_id' => 'bail|required|exists:cars,id',
            'user_id' => 'bail|required|exists:users,id',
            'start_date' => 'bail|required|date|after_or_equal:today',
            'end_date' => 'bail|required|date|after_or_equal:start_date',
        ];
    }

    public function after(): array
    {
        return [
            new NoConflictBookingDates(),
        ];
    }
}
