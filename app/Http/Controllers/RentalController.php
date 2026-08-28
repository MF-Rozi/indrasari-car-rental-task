<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Car;
use App\Models\Rental;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    /**
     * Show booking checkout page for a vehicle.
     */
    public function checkout(Request $request, Car $car): View|RedirectResponse
    {
        if ($car->status === 'maintenance') {
            return redirect()->route('catalog.show', $car)
                ->with('error', 'This vehicle is currently undergoing maintenance and is unavailable.');
        }

        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->addDays(2)->toDateString());

        return view('rentals.checkout', [
            'car' => $car,
            'user' => auth()->user(),
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Store and confirm a new vehicle reservation.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $car = Car::findOrFail($request->validated('car_id'));

        $this->bookingService->createBooking(
            user: auth()->user(),
            car: $car,
            startDate: $request->validated('start_date'),
            endDate: $request->validated('end_date')
        );

        return redirect()->route('rentals.my-rentals')
            ->with('success', 'Vehicle reservation confirmed successfully! Have a safe journey.');
    }

    /**
     * Display the authenticated customer's rental history.
     */
    public function myRentals(Request $request): View
    {
        $user = auth()->user();
        $status = $request->input('status', 'all');
        $today = Carbon::today()->toDateString();

        $query = $user->rentals()->with('car')->latest();

        if ($status === 'active') {
            $query->where('status', 'active')
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today);
        } elseif ($status === 'upcoming') {
            $query->where('status', 'active')
                ->where('start_date', '>', $today);
        } elseif ($status === 'completed') {
            $query->where('status', 'completed');
        } elseif ($status === 'cancelled') {
            $query->where('status', 'cancelled');
        }

        $rentals = $query->paginate(6)->withQueryString();

        // Calculate tab counts
        $allCount = $user->rentals()->count();
        $activeCount = $user->rentals()->where('status', 'active')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->count();
        $upcomingCount = $user->rentals()->where('status', 'active')
            ->where('start_date', '>', $today)
            ->count();
        $completedCount = $user->rentals()->where('status', 'completed')->count();
        $cancelledCount = $user->rentals()->where('status', 'cancelled')->count();

        return view('rentals.my-rentals', [
            'rentals' => $rentals,
            'currentStatus' => $status,
            'allCount' => $allCount,
            'activeCount' => $activeCount,
            'upcomingCount' => $upcomingCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount,
        ]);
    }

    /**
     * Cancel an upcoming reservation before pick-up date.
     */
    public function cancel(Rental $rental): RedirectResponse
    {
        $this->bookingService->cancelBooking(auth()->user(), $rental);

        return redirect()->route('rentals.my-rentals')
            ->with('success', 'Reservation successfully cancelled.');
    }
}
