<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use HttpResponse;
    public function paymentServerCallback(Request $request) {
        return 'ok';
    }

    public function singleCharge(StorePaymentRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */

         try {
            $userStripe = $user -> createOrGetStripeCustomer();

            $payment = $user->charge(
                $request->amount,
                $request->payment_method_id
            );

            $payment = $payment->asStripePaymentIntent();

            // $bill = $user->orders()
            //     ->create([
            //         'transaction_id' => $payment->charges->data[0]->id,
            //         'total' => $payment->charges->data[0]->amount
            //     ]);

            return $this -> success('Payment ok');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
