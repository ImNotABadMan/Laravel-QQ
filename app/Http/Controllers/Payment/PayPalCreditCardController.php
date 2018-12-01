<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Omnipay\Common\GatewayInterface;
use Omnipay\Omnipay;
use Omnipay\PayPal\PayPalItem;
use Omnipay\PayPal\ProGateway;

class PayPalCreditCardController extends Controller
{
    private $_merchantID = 'L96AM84UCNEQU';

    private $driver;

    private $username = '';

    private $password = '';

    private $signature = '';

    public function __construct()
    {
        $this->username = env('PAYPAL_DIRECT_PAYMENT_USERNAME');
        $this->password = env('PAYPAL_DIRECT_PAYMENT_PASSWORD');
        $this->signature = env('PAYPAL_DIRECT_PAYMENT_SIGNATURE');
    }

    /**
     * @return GatewayInterface|ProGateway
    */
    private function driver()
    {
        if(is_null($this->driver)){
            $this->driver = Omnipay::create('PayPal_Pro');
        }
        return $this->driver;
    }

    public function index()
    {
        return view('payment.paypal', [
            'merchantID' => $this->_merchantID
        ]);
    }

    public function getTransaction()
    {
        // 17P70054PN275430V
        $driver = $this->driver();
        $driver->setUsername($this->username)
            ->setPassword($this->password)
            ->setSignature($this->signature)
            ->setTestMode(true);
        $data = $driver->setParameter('transactionReference', '2NS08254L22458132')
            ->fetchTransaction()
            ->send();
        dump($data);
        $capture = $driver->setParameter('transactionReference', '2NS08254L22458132')
            ->capture([
                'amount' => 50
            ])
            ->send();
        dump($capture);
    }

    //
    public function ipn(Request $request)
    {
        Log::info($request->all());
    }
}
