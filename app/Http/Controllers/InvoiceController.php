<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display digital invoice / printable receipt for a completed rental.
     */
    public function show(Invoice $invoice): View
    {
        $user = auth()->user();

        // Enforce ownership: only the renter or admin can view the invoice
        if ($invoice->rental->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403, 'Unauthorized access to invoice.');
        }

        $invoice->load(['rental.car', 'rental.user']);

        return view('invoices.show', [
            'invoice' => $invoice,
            'rental' => $invoice->rental,
        ]);
    }
}
