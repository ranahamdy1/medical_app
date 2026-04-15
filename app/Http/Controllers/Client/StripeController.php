<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        try {
            $user = $request->user();

            $appointment = Appointment::where('id', $request->appointment_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $amount = max((float) $appointment->price, 0.5);

            $paymentIntent = PaymentIntent::create([
                'amount' => (int) round($amount * 100),
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
                'metadata' => [
                    'appointment_id' => $appointment->id,
                    'user_id' => $user->id,
                ],
            ]);

            $payment = PaymentTransaction::create([
                'price' => $appointment->price,
                'status' => 'pending',
                'user_id' => $user->id,
                'appointment_id' => $appointment->id,
                'stripe_payment_intent_id' => $paymentIntent->id,
            ]);

            return api_response(
                'success',
                'PaymentIntent created successfully',
                [
                    'client_secret' => $paymentIntent->client_secret,
                    'payment_id' => $payment->id,
                    'publishableKey' => config('services.stripe.public_key'),
                ]
            );

        } catch (\Exception $e) {
            \Log::error('Stripe createPaymentIntent error: ' . $e->getMessage());

            return api_response(
                'fail',
                'Failed to create PaymentIntent: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        try {
            $user = $request->user();

            $appointment = Appointment::where('id', $request->appointment_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            $payment = PaymentTransaction::where('appointment_id', $appointment->id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            if ($payment->status === 'paid') {
                return api_response('fail', 'Payment already completed', null, 400);
            }

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $intent = PaymentIntent::retrieve($payment->stripe_payment_intent_id);

            $intent->confirm([
                'payment_method' => $request->payment_method_id,
            ]);

            if ($intent->status === 'succeeded') {
                $payment->update(['status' => 'paid']);
                $appointment->update(['status' => 'paid']);
            }

            return api_response(
                $intent->status === 'succeeded' ? 'success' : 'fail',
                'Payment confirmation status',
                [
                    'stripe_status' => $intent->status,
                ]
            );

        } catch (\Exception $e) {
            \Log::error('Stripe confirmPayment error: ' . $e->getMessage());

            return api_response(
                'fail',
                'Failed to confirm payment: ' . $e->getMessage(),
                null,
                400
            );
        }
    }
}
