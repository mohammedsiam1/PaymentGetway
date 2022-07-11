<?php

namespace App\Http\Controllers\Payment;

use Exception;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\Payments\Thawani;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PaymentCallbackCantroller extends Controller
{
    public function success()
    {

        $payment_id = Session::get('payment_id');
        $session_id = Session::get('session_id');
        if (!$payment_id && $session_id)
            abort(404);

        $payment = Payment::findOrFail($payment_id);
        if ($payment->ref_id !== $session_id)
            abort(404);

        if ($payment->status == 'success')
            return 'success' ;

        $clint = new Thawani(
            config('services.thawani.secret_key'),
            config('services.thawani.publishable_key')
        );
        try {
            $response =  $clint->getcheckoutsession($session_id);
            if ($response['data']['payment_status'] == 'paid') {
                $payment->status = 'success';
                $payment->data = $response;
                $payment->save();
                Session::forget(['payment_id', 'session_id']);

                dd('success');
            }
        } catch (Exception $e) {
            dd ($e->getMessage());
        }
    }

    public function cancel()
    {
        //
    }
}
