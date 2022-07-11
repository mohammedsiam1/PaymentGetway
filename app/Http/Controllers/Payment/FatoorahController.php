<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Services\Payments\fatoorah;
use App\Http\Controllers\Controller;

class FatoorahController extends Controller
{
    protected  $fatoorah;
    public function __construct(fatoorah $fatoorah)
    {
        $this->fatoorah = $fatoorah;
    }
    public function create()
    {
        $data = [
            'NotificationOption' => 'Lnk', //'SMS', 'EML', or 'ALL'
            'InvoiceValue'       => '50',
            'CustomerName'       => 'mohammed',
            'CustomerEmail'      => 'mohammed@example.com',
            'Language'           => 'en',
            'DisplayCurrencyIso' => 'KWD',
            'CallBackUrl'        => 'http://127.0.0.1:8000/api/payment/success',
            'ErrorUrl'           => 'http://127.0.0.1:8000/api/payment/cancel',
        ];

      

        
        return  $this->fatoorah->sendpayment($data);

         // INSER INFORMATION IN TABLE X FROME MY DATABSE 
         // INVOICE ID && USER AUTH && ...
         

    }

    public function success(Request $request)
    {
        // CHECK USER PAID OR NOT FROM FATOORAH GETWAY

        $data = [];
        $data['Key']      = $request->paymentId;
        $data['KeyType']  = 'paymentId';
        $datapayment = $this->fatoorah->getpaymentStatus($data);
        return    $datapayment['Data']['InvoiceStatus'];

        // SERSH IN TABLE X ABOUT THE INVOICE ID == INVOICE ID (IN MY DATA BASE) 
        //   ...

    }
    public function cancel()
    {
        return 'cancel';
    }
}
