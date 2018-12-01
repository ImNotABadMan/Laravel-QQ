<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PayPalCreditCardController extends Controller
{
    private $_merchantID = 'L96AM84UCNEQU';

    public function index()
    {
        return view('payment.paypal', [
            'merchantID' => $this->_merchantID
        ]);
    }

    public function getTransction()
    {
        // 17P70054PN275430V
//        $drive
    }

    //
    public function ipn(Request $request)
    {
        Log::info($request->all());
    }
}
