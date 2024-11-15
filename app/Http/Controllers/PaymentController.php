<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class PaymentController extends Controller
{

    public function index(){
        return view('payments');
    }
    public function processPayment(Request $request)
{
    $validated = $request->validate([
        'card_owner' => 'required|string|max:255',
        'card_number' => 'required|digits_between:13,16',
        'cvc' => 'required|digits:3',
        'expiry_month' => 'required|digits:2',
        'expiry_year' => 'required|digits:4',
    ]);

    // Save payment as "Pending" in the database
    $payment = Payments::create([
        'customer_name' => $validated['card_owner'],
        'card_number' => encrypt($validated['card_number']), // Encrypt for security
        'cvc' => encrypt($validated['cvc']),
        'expiry_month' => encrypt($validated['expiry_month']),
        'expiry_year' => encrypt($validated['expiry_year']),
        'amount' => 300.00, // Replace with actual amount
        'status' => 'pending',
    ]);

    return redirect()->route('payment.index')->with('success', 'Your payment is pending. Admin will review it soon.');
}

}
