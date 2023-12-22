<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use Illuminate\Support\Facades\Log;

class BookingCreatedListener
{
    public function handle(BookingCreated $event): void
    {
        $carId = $event->booking->car_id;
        $userId = $event->booking->user_id;
        $startDate = $event->booking->start_date;
        $endDate = $event->booking->end_date;

        Log::info("Car $carId booked by user $userId from $startDate to $endDate");
    }
}
