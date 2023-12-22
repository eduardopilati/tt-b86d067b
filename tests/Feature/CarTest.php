<?php

namespace Tests\Feature;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CarTest extends TestCase
{
    public function testCanAccessCarScreen(): void
    {
        $response = $this->logged()->get('/cars');

        $response->assertStatus(200);
    }

    public function testCanAccessCarScreenWithCars(): void
    {
        Car::factory()->count(5)->create();
        $response = $this->logged()->get('/cars');

        $response->assertStatus(200);

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Cars/ListCars')
            ->has('cars.data', 5));
    }

    public function testCanAccessCreateCarScreen(): void
    {
        $response = $this->logged()->get('/cars/create');

        $response->assertStatus(200);
    }

    public function testCanCreateCar(): void
    {
        $newCar = Car::factory()->make();

        $response = $this->logged()->post('/cars', [
            'model' => $newCar->model,
            'plate' => $newCar->plate,
            'brand' => $newCar->brand,
            'year' => $newCar->year,
        ]);

        $response->assertRedirect('/cars');

        $this->assertDatabaseHas('cars', [
            'model' => $newCar->model,
            'plate' => $newCar->plate,
            'brand' => $newCar->brand,
            'year' => $newCar->year,
        ]);
    }

    public function testCantCreateCarInvalidPlate(): void
    {
        $newCar = Car::factory()->make();

        $response = $this->logged()->post('/cars', [
            'model' => $newCar->model,
            'plate' => 'AAAAAAA',
            'brand' => $newCar->brand,
            'year' => $newCar->year,
        ]);

        $response->assertInvalid(['plate']);
    }

    public function testCantCreateCarDuplicatePlate(): void
    {
        $car = Car::factory()->create();

        $response = $this->logged()->post('/cars', [
            'model' => $car->model,
            'plate' => $car->plate,
            'brand' => $car->brand,
            'year' => $car->year,
        ]);

        $response->assertInvalid(['plate']);
    }

    public function testCantCreateCarInvalidYear(): void
    {
        $newCar = Car::factory()->make();

        $response = $this->logged()->post('/cars', [
            'model' => $newCar->model,
            'plate' => $newCar->plate,
            'brand' => $newCar->brand,
            'year' => Carbon::now()->year + 1,
        ]);

        $response->assertInvalid(['year']);
    }

    public function testCantCreateCarMissingFields(): void
    {
        $response = $this->logged()->post('/cars', []);

        $response->assertInvalid([
            'model',
            'plate',
            'brand',
            'year',
        ]);
    }

    public function testCanAccessEditCarScreen(): void
    {
        $car = Car::factory()->create();
        $response = $this->logged()->get("/cars/{$car->id}/edit");

        $response->assertStatus(200);
    }

    public function testCanUpdateCar(): void
    {
        $car = Car::factory()->create();
        $newCar = Car::factory()->make();

        $response = $this->logged()->put("/cars/$car->id", [
            'model' => $newCar->model,
            'plate' => $newCar->plate,
            'brand' => $newCar->brand,
            'year' => $newCar->year,
        ]);

        $response->assertRedirect('/cars');

        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'model' => $newCar->model,
            'plate' => $newCar->plate,
            'brand' => $newCar->brand,
            'year' => $newCar->year,
        ]);
    }

    public function testCantUpdateCarInvalidPlate(): void
    {
        $car = Car::factory()->create();
        $newCar = Car::factory()->make();

        $response = $this->logged()->put("/cars/$car->id", [
            'model' => $newCar->model,
            'plate' => 'AAAAAAA',
            'brand' => $newCar->brand,
            'year' => $newCar->year,
        ]);

        $response->assertInvalid(['plate']);
    }

    public function testCantUpdateCarInvalidYear(): void
    {
        $car = Car::factory()->create();
        $newCar = Car::factory()->make();

        $response = $this->logged()->put("/cars/$car->id", [
            'model' => $newCar->model,
            'plate' => $newCar->plate,
            'brand' => $newCar->brand,
            'year' => Carbon::now()->year + 1,
        ]);

        $response->assertInvalid(['year']);
    }

    public function testCanDeleteCar(): void
    {
        $car = Car::factory()->create();

        $response = $this->logged()->delete("/cars/$car->id");

        $response->assertRedirect('/cars');

        $this->assertDatabaseMissing('cars', [
            'id' => $car->id,
        ]);
    }

    public function testCanSearchCar(): void
    {
        Car::factory()->count(3)->create([
            'model' => 'Orange',
        ]);

        Car::factory()->count(3)->create([
            'model' => 'Pumpkin',
        ]);

        $response = $this->logged()->get('/cars/search?searchTerm=Orange');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $page) => $page
            ->count(3));
    }

    public function testCanSearchAllCars(): void
    {
        Car::factory()->count(3)->create([
            'model' => 'Ferrari',
        ]);

        Car::factory()->count(3)->create([
            'model' => 'Lamborghini',
        ]);

        $response = $this->logged()->get('/cars/search?searchTerm=');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) => $json
            ->count(6));
    }
}
