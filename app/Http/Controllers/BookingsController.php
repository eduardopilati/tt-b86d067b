<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\FilterBookingRequest;
use App\Http\Requests\Booking\NewBookingRequest;
use App\Models\Booking;
use App\Models\Car;
use Inertia\Inertia;

class BookingsController extends Controller
{
    public function index(FilterBookingRequest $request)
    {
        $user = $request->getQueryUser();
        $car = $request->getQueryCar();

        $bookings = $request->getFilteredBookings()
            ->with(['user', 'car'])
            ->paginate();

        return Inertia::render('Bookings/ListBookings', compact('bookings', 'user', 'car'));
    }

    public function create(Car $car)
    {
        return Inertia::render('Bookings/CreateBooking', compact('car'));
    }

    public function store(NewBookingRequest $request, Car $car)
    {
        Booking::create($request->all());
        return redirect()->route('bookings.index', $car);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index');
    }

    public function print(FilterBookingRequest $request)
    {
        $user = $request->getQueryUser();
        $car = $request->getQueryCar();

        $bookings = $request->getFilteredBookings()
            ->with(['user', 'car'])
            ->get();

        return Inertia::render('Bookings/PrintBookings', compact('bookings', 'user', 'car'));
    }
}
