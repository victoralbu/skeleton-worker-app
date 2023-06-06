<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalPaymentController extends Controller
{
    public function handlePayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent"              => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units"      => [
                0 => [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value"         => $request->get('amount')
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] !== null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] === 'approve') {
                    return response()->json(['href' => $links['href']]);
                }
            }

            return redirect('http://zeusv.go.ro:3001/my-workers?status=Something-went-wrong');
        }

        return redirect('http://zeusv.go.ro:3001/my-workers?status=Something-went-wrong');
    }

    public function paymentCancel()
    {
        return redirect('http://zeusv.go.ro:3001/my-workers?status=Canceled-payment')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {

            return redirect('http://zeusv.go.ro:3001/my-workers?status=Good')
                ->with('success', 'Transaction complete.');
        }

        return redirect('http://zeusv.go.ro:3001/my-workers?status=Something-went-wrong')
            ->with('error', $response['message'] ?? 'Something went wrong.');
    }
}
