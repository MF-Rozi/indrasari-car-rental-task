<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Invoice;
use App\Models\Rental;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the centralized admin dashboard with aggregated performance metrics.
     */
    public function index(): View
    {
        $totalCars = Car::count();
        $availableCars = Car::where('status', 'available')->count();
        $rentedCars = Car::where('status', 'rented')->count();
        $maintenanceCars = Car::where('status', 'maintenance')->count();

        $activeRentals = Rental::where('status', 'active')->count();
        $totalCustomers = User::where('role', 'customer')->count();

        $totalRevenue = (int) Invoice::where('payment_status', 'paid')->sum('total_amount');
        $formattedTotalRevenue = 'Rp ' . number_format($totalRevenue, 0, ',', '.');

        $recentRentals = Rental::with(['user', 'car', 'invoice'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', [
            'totalCars' => $totalCars,
            'availableCars' => $availableCars,
            'rentedCars' => $rentedCars,
            'maintenanceCars' => $maintenanceCars,
            'activeRentals' => $activeRentals,
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue,
            'formattedTotalRevenue' => $formattedTotalRevenue,
            'recentRentals' => $recentRentals,
        ]);
    }
}
