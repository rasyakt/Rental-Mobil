<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['booking.customer.user', 'booking.vehicle'])->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['booking.customer.user', 'booking.vehicle'])->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify($id)
    {
        $payment = Payment::with('booking')->findOrFail($id);
        $payment->update([
            'status' => 'completed',
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        // If booking is still pending, move to confirmed
        if ($payment->booking->status === 'pending') {
            $payment->booking->update(['status' => 'confirmed']);
        }

        return redirect()->back()->with('success', 'Pembayaran telah berhasil diverifikasi.');
    }

    public function reject(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => 'failed',
            'admin_notes' => $request->reason
        ]);

        return redirect()->back()->with('success', 'Pembayaran telah ditolak.');
    }

    public function refund($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => 'refunded'
        ]);

        return redirect()->back()->with('success', 'Pembayaran telah di-refund.');
    }
}
