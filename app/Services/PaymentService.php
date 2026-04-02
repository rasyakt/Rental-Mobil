<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Exception;

class PaymentService
{
    /**
     * Create payment record
     */
    public function createPayment(Booking $booking, $amount, $paymentMethod, $paymentDetails = null)
    {
        $payment = Payment::create([
            'payment_number' => 'PM' . date('YmdHis') . random_int(100, 999),
            'booking_id' => $booking->id,
            'amount' => $amount,
            'payment_method' => $paymentMethod,
            'status' => 'pending',
            'payment_details' => $paymentDetails,
        ]);

        return $payment;
    }

    /**
     * Process Midtrans payment
     */
    public function processMidtrans(Payment $payment)
    {
        try {
            // Initialize Midtrans
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $booking = $payment->booking;
            $customer = $booking->customer;

            $transactionDetails = [
                'order_id' => $payment->payment_number,
                'gross_amount' => (int)$payment->amount,
            ];

            $itemDetails = [
                [
                    'id' => $booking->vehicle_id,
                    'price' => (int)$booking->total_price,
                    'quantity' => 1,
                    'name' => $booking->vehicle->brand . ' ' . $booking->vehicle->model,
                ],
            ];

            $customerDetails = [
                'first_name' => $customer->user->name,
                'email' => $customer->user->email,
                'phone' => $customer->phone,
            ];

            $transaction = [
                'transaction_details' => $transactionDetails,
                'item_details' => $itemDetails,
                'customer_details' => $customerDetails,
                'callbacks' => [
                    'finish' => route('customer.payments.show', $payment->id),
                    'error' => route('customer.payments.show', $payment->id),
                    'pending' => route('customer.payments.show', $payment->id),
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            
            $payment->update([
                'payment_details' => [
                    'snap_token' => $snapToken,
                    'gateway' => 'midtrans',
                ],
            ]);

            return $snapToken;
        } catch (Exception $e) {
            throw new Exception('Gagal memproses pembayaran Midtrans: ' . $e->getMessage());
        }
    }

    /**
     * Verify Midtrans payment
     */
    public function verifyMidtrans($orderId)
    {
        try {
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);

            $status = \Midtrans\Transaction::status($orderId);

            $payment = Payment::where('payment_number', $orderId)->first();
            if (!$payment) {
                throw new Exception('Payment not found');
            }

            if ($status->transaction_status === 'settlement' || $status->transaction_status === 'capture') {
                $payment->update([
                    'status' => 'success',
                    'transaction_id' => $status->transaction_id,
                    'paid_at' => now(),
                ]);

                // Update booking status
                $payment->booking->update(['status' => 'confirmed']);

                return $payment;
            } elseif ($status->transaction_status === 'pending') {
                $payment->update(['status' => 'waiting_confirmation']);
                return $payment;
            } else {
                $payment->update([
                    'status' => 'failed',
                    'failure_reason' => $status->transaction_status,
                ]);
                return $payment;
            }
        } catch (Exception $e) {
            throw new Exception('Gagal verifikasi pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Mark payment as paid
     */
    public function markAsPaid(Payment $payment, $transactionId = null)
    {
        $payment->update([
            'status' => 'success',
            'transaction_id' => $transactionId,
            'paid_at' => now(),
        ]);

        // Update booking status
        $payment->booking->update(['status' => 'confirmed']);

        return $payment;
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed(Payment $payment, $reason = null)
    {
        $payment->update([
            'status' => 'failed',
            'failure_reason' => $reason,
        ]);

        return $payment;
    }
}
