<?php

namespace App\Classes\Validation;

use App\Models\Booking;
use Illuminate\Validation\Validator;

class NoConflictBookingDates
{
    /**
     * Verify if there is another booking for the same car in the same period.
     */
    public function __invoke(Validator $validator): void
    {
        $startDate = request()->start_date;
        $endDate = request()->end_date;
        $carId = request()->car_id;

        if (!$startDate || !$endDate || !$carId) {
            return;
        }

        $anotherBooking = Booking::where('car_id', $carId)
            ->where(fn ($query) =>
                $query->where(fn ($query) =>
                    // Verify id start and end date conflics with another booking
                    $query->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate]))
                ->orWhere(fn ($query) =>
                    // Verify new booking are inside another booking
                    $query->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate)))
            ->exists();

        if ($anotherBooking) {
            $validator->errors()->add('start_date', 'Existe uma outra reserva para este período.');
        }
    }
}
