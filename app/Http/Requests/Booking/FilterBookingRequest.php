<?php

namespace App\Http\Requests\Booking;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class FilterBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getFilteredBookings(): Builder
    {
        $query = Booking::query();

        if ($this->query('user')) {
            $query->where('user_id', $this->query('user'));
        }

        if ($this->query('car')) {
            $query->where('car_id', $this->query('car'));
        }

        return $query;
    }

    public function getQueryUser(): User | null
    {
        if ($this->query('user')) {
            return User::findOrFail($this->query('user'));
        }
        return null;
    }

    public function getQueryCar(): Car | null
    {
        if ($this->query('car')) {
            return Car::findOrFail($this->query('car'));
        }
        return null;
    }
}
