<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $customer = auth()->user()->customer;
        $payments = Payment::whereHas('booking', function ($q) use ($customer) {
            $q->where('customer_id', $customer->id);
        })->latest()->paginate(10);

        return view('customer.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('customer.payments.show', compact('payment'));
    }

    public function process(Request $request)
    {
        // Implementation for processing payment
        return redirect()->back();
    }

    public function midtransCallback(Request $request)
    {
        // Handle Midtrans callback
        return response()->json(['status' => 'ok']);
    }

    public function xenditCallback(Request $request)
    {
        // Handle Xendit callback
        return response()->json(['status' => 'ok']);
    }
}
