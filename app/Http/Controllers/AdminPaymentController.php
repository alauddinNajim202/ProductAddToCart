<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payments::all();
        return view('admin.payment', compact('payments'));
    }

    public function approve(Payments $payment)
    {
        // Decrypt card details
        $cardNumber = decrypt($payment->card_number);
        $cvc = decrypt($payment->cvc);
        $expiryMonth = decrypt($payment->expiry_month);
        $expiryYear = decrypt($payment->expiry_year);

        // Process the payment via Authorize.net
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('AUTHORIZE_NET_API_LOGIN_ID'));
        $merchantAuthentication->setTransactionKey(env('AUTHORIZE_NET_TRANSACTION_KEY'));

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate("$expiryYear-$expiryMonth");
        $creditCard->setCardCode($cvc);

        $paymentType = new AnetAPI\PaymentType();
        $paymentType->setCreditCard($creditCard);

        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType("authCaptureTransaction");
        $transactionRequest->setAmount($payment->amount);
        $transactionRequest->setPayment($paymentType);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest($transactionRequest);

        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
            $payment->update(['status' => 'success']);
            return back()->with('success', 'Payment approved and processed successfully!');
        } else {
            $error = $response->getMessages()->getMessage()[0]->getText();
            return back()->with('error', 'Payment processing failed: ' . $error);
        }
    }

    public function reject(Payments $payment)
    {
        $payment->update(['status' => 'rejected']);
        return back()->with('info', 'Payment has been rejected.');
    }
}
