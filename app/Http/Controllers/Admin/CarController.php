<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCarRequest;
use App\Http\Requests\Admin\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CarController extends Controller
{
    /**
     * Display a listing of fleet vehicles with search and status filtering.
     */
    public function index(Request $request): View
    {
        $query = Car::query();

        // Search keyword
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('license_plate', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            if (in_array($status, ['available', 'rented', 'maintenance'])) {
                $query->where('status', $status);
            }
        }

        $cars = $query->latest()->paginate(10)->withQueryString();

        return view('admin.cars.index', [
            'cars' => $cars,
            'currentSearch' => $request->input('search', ''),
            'currentStatus' => $request->input('status', 'all'),
        ]);
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create(): View
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(StoreCarRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Vehicle added to fleet successfully.');
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(Car $car): View
    {
        return view('admin.cars.edit', [
            'car' => $car,
        ]);
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(UpdateCarRequest $request, Car $car): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Remove previous image file if exists
            if ($car->image_path && Storage::disk('public')->exists($car->image_path)) {
                Storage::disk('public')->delete($car->image_path);
            }

            $data['image_path'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Vehicle details updated successfully.');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy(Car $car): RedirectResponse
    {
        if ($car->isRented()) {
            return back()->with('error', 'Cannot delete vehicle that is currently rented.');
        }

        if ($car->image_path && Storage::disk('public')->exists($car->image_path)) {
            Storage::disk('public')->delete($car->image_path);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Vehicle removed from fleet successfully.');
    }
}
