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
            'car_id' => 'required|exists:cars,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function after(): array
    {
        return [
            new NoConflictBookingDates(),
        ];
    }
}
