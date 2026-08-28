<?php

namespace App\Http\Controllers;

use App\Services\ReturnService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReturnController extends Controller
{
    public function __construct(
        protected ReturnService $returnService
    ) {}

    /**
     * Display vehicle return page with license plate search and active rentals list.
     */
    public function showReturn(Request $request): View
    {
        $user = auth()->user();
        $activeRentals = $user->rentals()
            ->with('car')
            ->where('status', 'active')
            ->get();

        $licensePlate = $request->input('license_plate');
        $verifiedRental = null;
        $summary = null;

        if ($licensePlate) {
            try {
                $verifiedRental = $this->returnService->verifyActiveRental($user, $licensePlate);
                $summary = $this->returnService->calculateReturnSummary($verifiedRental);
            } catch (ValidationException $e) {
                // Pass validation error to view if plate not found
                session()->flash('error', $e->getMessage());
            }
        }

        return view('rentals.return', [
            'activeRentals' => $activeRentals,
            'licensePlate' => $licensePlate ?? '',
            'verifiedRental' => $verifiedRental,
            'summary' => $summary,
        ]);
    }

    /**
     * Process vehicle return confirmation and redirect to digital invoice.
     */
    public function confirmReturn(Request $request): RedirectResponse
    {
        $request->validate([
            'license_plate' => ['required', 'string'],
        ]);

        $user = auth()->user();
        $rental = $this->returnService->verifyActiveRental($user, $request->input('license_plate'));
        $invoice = $this->returnService->processReturn($user, $rental);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Vehicle returned successfully! Here is your official invoice and receipt.');
    }
}
