<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cart::where('users_id', Auth::user()->id)->get();
        $user = Auth::user();

        $data['user'] = $user;

        return $this->sendResponse($data, 'Successfully get data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $transactionCode = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4) . mt_rand(100000, 999999);

        $billingItem = Cart::where('users_id', Auth::user()->id)->get();

        $totalPayment = 0;
        foreach ($billingItem as $item) {
            $totalPayment += $item->product->price * $item->quantity;
        }

        $billing = Billing::create([
            'transaction_code' => $transactionCode,
            'total_payment' => $totalPayment,
            'payment_method' => $data['payment_method'],
        ]);

        foreach ($billingItem as $item) {
            BillingDetails::create([
                'billing_id' => $billing->id,
                'product_id' => $item->product_id,
                'user_id' => Auth::user()->id,
                'purchase_price' => $item->product->price
            ]);
        }

        $user = User::find(Auth::user()->id);
        if($user) {
            try {
                $user->update([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'company_name' => $data['company_name'],
                    'country' => $data['country'],
                    'province' => $data['province'],
                    'zip_code' => $data['zip_code'],
                    'additional_info' => $data['additional_info'],
                ]);
            } catch (\Exception $e) {
                return $this->sendError('Error updating user: ' . $e->getMessage(), 500);
            }
        }

        return $this->sendResponse($billing, 'Successfully make transaction');
    }
}
