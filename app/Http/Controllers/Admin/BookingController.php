<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display all customer bookings across the system with filtering.
     */
    public function index(Request $request): View
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search');
        $date = $request->input('date');

        $query = Rental::with(['user', 'car', 'invoice'])->latest();

        if (! empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('sim_number', 'like', "%{$search}%");
                })->orWhereHas('car', function ($cq) use ($search) {
                    $cq->where('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('license_plate', 'like', "%{$search}%");
                });
            });
        }

        if (! empty($date)) {
            $query->where(function ($q) use ($date) {
                $q->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
            });
        }

        $bookings = $query->paginate(10)->withQueryString();

        // Counter stats
        $allCount = Rental::count();
        $activeCount = Rental::where('status', 'active')->count();
        $completedCount = Rental::where('status', 'completed')->count();
        $cancelledCount = Rental::where('status', 'cancelled')->count();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'currentStatus' => $status,
            'currentSearch' => $search ?? '',
            'currentDate' => $date ?? '',
            'allCount' => $allCount,
            'activeCount' => $activeCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount,
        ]);
    }

    /**
     * Display detailed booking audit for a single reservation.
     */
    public function show(Rental $rental): View
    {
        $rental->load(['user', 'car', 'invoice']);

        return view('admin.bookings.show', [
            'rental' => $rental,
        ]);
    }
}
