<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Display the vehicle fleet catalog with search and filtering.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $brand = $request->input('brand');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sort = $request->input('sort', 'latest');

        // Retrieve distinct available brands for quick filter pills
        $brands = Car::select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        $cars = Car::query()
            ->search($search)
            ->brand($brand)
            ->availableForDates($startDate, $endDate)
            ->sortByRate($sort)
            ->paginate(9)
            ->withQueryString();

        return view('catalog.index', [
            'cars' => $cars,
            'brands' => $brands,
            'currentSearch' => $search ?? '',
            'currentBrand' => $brand ?? 'all',
            'currentSort' => $sort,
            'startDate' => $startDate ?? '',
            'endDate' => $endDate ?? '',
        ]);
    }

    /**
     * Display detailed specifications for a single vehicle.
     */
    public function show(Car $car): View
    {
        // Related vehicles from same brand or similar category
        $relatedCars = Car::where('id', '!=', $car->id)
            ->where('status', 'available')
            ->where(function ($q) use ($car) {
                $q->where('brand', $car->brand)
                    ->orWhere('seating_capacity', $car->seating_capacity);
            })
            ->take(3)
            ->get();

        return view('catalog.show', [
            'car' => $car,
            'relatedCars' => $relatedCars,
        ]);
    }
}
