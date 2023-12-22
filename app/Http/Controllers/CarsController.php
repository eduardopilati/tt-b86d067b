<?php

namespace App\Http\Controllers;

use App\Http\Requests\Car\CreateCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarsController extends Controller
{
    public function index()
    {
        $cars = Car::paginate(10);
        return Inertia::render('Cars/ListCars', compact('cars'));
    }

    public function create()
    {
        return Inertia::render('Cars/CreateCar');
    }

    public function store(CreateCarRequest $request)
    {
        Car::create($request->all());
        return redirect()->route('cars.index');
    }

    public function edit(Car $car)
    {
        return Inertia::render('Cars/EditCar', compact('car'));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->only('model', 'brand', 'plate', 'year'));

        return redirect()->route('cars.index');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $cars = Car::select('id')
            ->selectRaw('concat(model, " / ", brand, " / ", year, " - ", plate) as text')
            ->where('model', 'LIKE', "%$searchTerm%")
            ->orWhere('brand', 'LIKE', "%$searchTerm%")
            ->orWhere('plate', 'LIKE', "%$searchTerm%")
            ->orWhere('year', 'LIKE', "%$searchTerm%")
            ->take(10)
            ->get();

        return response()->json($cars);
    }
}
