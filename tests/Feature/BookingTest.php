<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class BookingTest extends TestCase
{
    private function createAndTestBooking($car, $user, $startDate, $endDate): void
    {
        $response = $this->logged()->post('/bookings', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        $response->assertRedirect('/bookings');

        $this->assertDatabaseHas('bookings', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);
    }

    public function testCanAccessBookingScreen(): void
    {
        $response = $this->logged()->get('/bookings');

        $response->assertStatus(200);
    }

    public function testCanAccessBookingScreenWithBookings(): void
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();
        Booking::factory()->count(5)->create([
            'user_id' => $user->id,
            'car_id' => $car->id,
        ]);

        $response = $this->logged()->get('/bookings');

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Bookings/ListBookings')
            ->has('bookings.data', 5)
            ->has('bookings.data.0.user')
            ->where('bookings.data.0.user.id', $user->id)
            ->has('bookings.data.0.car')
            ->where('bookings.data.0.car.id', $car->id));
    }

    public function testCanAccessBookingScreenUserFiltered(): void
    {
        $user = User::factory()->create();

        Booking::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        Booking::factory()->count(5)->create();

        $response = $this->logged()->get("/bookings?user=$user->id");

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Bookings/ListBookings')
            ->has('bookings.data', 5));
    }

    public function testCanAccessBookingScreenCarFiltered(): void
    {
        $car = Car::factory()->create();

        Booking::factory()->count(5)->create([
            'car_id' => $car->id,
        ]);

        Booking::factory()->count(5)->create();

        $response = $this->logged()->get("/bookings?car=$car->id");

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Bookings/ListBookings')
            ->has('bookings.data', 5));
    }

    public function testCanAccessBookingScreenCarAndUserFiltered(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        Booking::factory()->count(5)->create([
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        Booking::factory()->count(5)->create([
            'car_id' => $car->id,
        ]);

        Booking::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        Booking::factory()->count(5)->create();

        $response = $this->logged()->get("/bookings?car=$car->id&user=$user->id");

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Bookings/ListBookings')
            ->has('bookings.data', 5));
    }

    public function testCanAccessCreateBookingScreen(): void
    {
        $car = Car::factory()->create();

        $response = $this->logged()->get("/bookings/create?car=$car->id");

        $response->assertStatus(200);
    }

    public function testCanCreateBooking(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(1)->format('Y-m-d'),
            Carbon::now()->addDays(2)->format('Y-m-d')
        );
    }

    public function testCanCreateSeveralBookings(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(1)->format('Y-m-d'),
            Carbon::now()->addDays(2)->format('Y-m-d')
        );

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(3)->format('Y-m-d'),
            Carbon::now()->addDays(4)->format('Y-m-d')
        );

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(5)->format('Y-m-d'),
            Carbon::now()->addDays(6)->format('Y-m-d')
        );

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(7)->format('Y-m-d'),
            Carbon::now()->addDays(8)->format('Y-m-d')
        );

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(9)->format('Y-m-d'),
            Carbon::now()->addDays(10)->format('Y-m-d')
        );
    }

    public function testCanCreateBookingDiferentCarsSamePeriod(): void
    {
        $car1 = Car::factory()->create();
        $car2 = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car1,
            $user,
            Carbon::now()->addDays(1)->format('Y-m-d'),
            Carbon::now()->addDays(2)->format('Y-m-d')
        );

        $this->createAndTestBooking(
            $car2,
            $user,
            Carbon::now()->addDays(1)->format('Y-m-d'),
            Carbon::now()->addDays(2)->format('Y-m-d')
        );
    }

    public function testCantCreateBookingSameCarsSamePeriod(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(1)->format('Y-m-d'),
            Carbon::now()->addDays(2)->format('Y-m-d')
        );

        $response = $this->logged()->post('/bookings', [
            'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function testCantCreateOverlapingBookingsInside(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(1)->format('Y-m-d'),
            Carbon::now()->addDays(5)->format('Y-m-d')
        );

        $response = $this->logged()->post('/bookings', [
            'start_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function testCantCreateOverlapingBookingsEnd(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(1)->format('Y-m-d'),
            Carbon::now()->addDays(5)->format('Y-m-d')
        );

        $response = $this->logged()->post('/bookings', [
            'start_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function testCantCreateOverlapingBookingsStart(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(3)->format('Y-m-d'),
            Carbon::now()->addDays(5)->format('Y-m-d')
        );

        $response = $this->logged()->post('/bookings', [
            'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function testCantCreateOverlapingBookingsOutside(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(2)->format('Y-m-d'),
            Carbon::now()->addDays(3)->format('Y-m-d')
        );

        $response = $this->logged()->post('/bookings', [
            'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function testCantCreateOverlapingBookingsEnd1Start2(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(1)->format('Y-m-d'),
            Carbon::now()->addDays(3)->format('Y-m-d')
        );

        $response = $this->logged()->post('/bookings', [
            'start_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function testCantCreateOverlapingBookingsStart1End2(): void
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();

        $this->createAndTestBooking(
            $car,
            $user,
            Carbon::now()->addDays(3)->format('Y-m-d'),
            Carbon::now()->addDays(5)->format('Y-m-d')
        );

        $response = $this->logged()->post('/bookings', [
            'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function testCantCreateMissingFields(): void
    {
        $response = $this->logged()->post('/bookings', []);

        $response->assertInvalid([
            'start_date',
            'end_date',
            'car_id',
            'user_id',
        ]);
    }

    public function testCanDestroyBooking(): void
    {
        $booking = Booking::factory()->create();

        $response = $this->logged()->delete("/bookings/$booking->id");

        $response->assertRedirect('/bookings');

        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id,
        ]);
    }
}
