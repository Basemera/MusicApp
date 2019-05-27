<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Unicodeveloper\Paystack\Paystack;
use App\User;

class PaymentController extends Controller
{
    //
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        $paystack = new Paystack();
        return $paystack->getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paystack = new Paystack();
        $paymentDetails = $paystack->getPaymentData();

        $email = $paymentDetails['data']['customer']['email'];
        if ($paymentDetails['message'] == "Verification successful") {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->premium_user = true;
                $user->save();
                return response()->json($user, 200);
            }
        }

        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
