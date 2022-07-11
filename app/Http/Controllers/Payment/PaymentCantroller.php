<?php

namespace App\Http\Controllers\Payment;

use Exception;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\Payments\Thawani;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentCantroller extends Controller
{
   public function create(){
    $clint =new Thawani(config('services.thawani.secret_key'),
                        config('services.thawani.publishable_key'));
    $data=[
        'client_reference_id'=>'test payment',
        'mode'=>'payment',
        'products'=>[
            [
            'name'=>'test payment',
            'unit_amount'=>100,
            'quantity'=>2,
        ],
    ],
        'success_url'=>route('payment.success'),
        'cancel_url'=>route('payment.cancel'),
    ];
    try{
   $session_id= $clint->createCheckoutSession($data);
        $payment=Payment::forceCreate([
            'user_id'=>Auth::id(),
            'gateway'=>'thawani',
            'ref_id'=> $session_id,
            'status'=>'pending',
            'amount'=>100*1000,
        ]);
        Session::put('payment_id',$payment->id);
        Session::put('session_id',$session_id);
        
   return redirect()->away($clint->getpayurl($session_id));

}
catch(Exception $e){
    dd($e->getMessage());
}
   }
}
