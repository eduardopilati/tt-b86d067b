<?php

namespace App\Classes\Validation;

use App\Models\Booking;
use Illuminate\Validation\Validator;

class NoConflictBookingDates
{
    public function __invoke(Validator $validator): void
    {
        $startDate = request()->start_date;
        $endDate = request()->end_date;

        $anotherBooking = Booking::where(function ($query) use ($startDate, $endDate): void {
            $query->where('start_date', '>=', $startDate)
                ->where('start_date', '<=', $endDate);
        })->orWhere(function ($query) use ($startDate, $endDate): void {
            $query->where('end_date', '>=', $startDate)
                ->where('end_date', '<=', $endDate);
        })->exists();

        if ($anotherBooking) {
            $validator->errors()->add('start_date', 'Existe uma outra reserva para este período.');
        }
    }
}
