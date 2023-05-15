<?php

namespace App\Http\Controllers;

use App\Models\PaymentAccount;
use App\Http\Requests\StorePaymentAccountRequest;
use App\Http\Requests\UpdatePaymentAccountRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class PaymentAccountController extends Controller
{
    use HttpResponse;
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        /**
         * @var User $user
         */
        $exist = $user -> paymentAccount() -> exists();

        $account = $user -> paymentAccount() -> get();
        
        if(!$exist) {
            return $this->failure("not found account");
        } else {
            return $this->success("get account success", $account);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentAccountRequest $request)
    {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $exist = $user -> paymentAccount() -> exists();
        
        if($exist) {
            return $this->failure("user have a account");
        } 

        $account = $user -> paymentAccount() -> get();

        

        $newAccount = $user -> paymentAccount() -> create([
            'account_name' => $request -> account_name,
            'card_number' => $request -> card_number,
            'exp_date' => $request -> exp_date,
            'cvv' => $request -> cvv,
            'country' => $request -> country,
        ]);

        return $this->success('create account complete', $newAccount);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentAccountRequest $request)
    {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $exist = $user -> paymentAccount() -> exists();
        
        if(!$exist) {
            return $this->failure("user not have a account");
        }

        $account = $user -> paymentAccount() -> get();

        /**
         * @var PaymentAccount $account
         */

        if($request -> account_name) {
            $account -> account_name = $request -> account_name;
        }

        if($request -> card_number) {
            $account -> card_number = $request -> card_number;
        }

        if($request -> exp_date) {
            $account -> exp_date = $request -> exp_date;
        }

        if($request -> cvv) {
            $account -> cvv = $request -> cvv;
        }

        if($request -> country) {
            $account -> country = $request -> country;
        }

        $account->save();

        return $this->success('create account complete', $account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $exist = $user -> paymentAccount() -> exists();
    
        if(!$exist) {
            return $this->failure("user not have a account");
        }

        $account = $user -> paymentAccount() -> get();

        /**
         * @var PaymentAccount $account
         */

        $account -> delete();

        return $this->success('deleted');
    }
}
