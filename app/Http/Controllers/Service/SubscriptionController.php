<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\PaymentReceipt;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index () 
    {
        return view('service.subscription.index');
    }

    public function subscription() 
    {
        $url = url('pay-now');
        if(auth()->user()->expires_at > now()->today() && auth()->user()->is_trial == 0) {
            $url = 'javascript:void(0);';
            $title = 'Purchased';
        } else{
            $title = 'Purchase';
        }
        return view('subscription.index', compact('url', 'title'));
    }

    public  function payNowForm () 
    {
        $payNow = $this->payNow();
        if($payNow['status'] == 0 && auth()->user()->expires_at > now()->today()){
            return redirect()->back()->with('error', $payNow['message']);
        } else{
            if($payNow['status'] == 1){
                return back()->with('success', $payNow['message']);
            }
            return view('subscription.pay-now');
        }
    }

    /** Pay now */
    public function payNow()
    {
        try{
            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
    
            // Card list
            $card_list = $stripe->customers->allSources(
                auth()->user()->customer_id, ['object' => 'card']
            );

            if(count($card_list->data) > 0){
                // Charge create
                $charge = $stripe->charges->create([
                    'customer'     =>  auth()->user()->customer_id,
                    'amount'       =>  99.99 * 100,
                    'currency'     =>  'USD',
                    'source'       =>  $card_list->data[0]->id,
                    'description'  => 'Subscription Fee'
                ]);
        
                if($charge){
                    auth()->user()->is_trial = 0;
                    auth()->user()->expires_at = now()->addMonth();
                    auth()->user()->save();
    
                    $paymentReceipt = new PaymentReceipt();
                    $paymentReceipt->user_id = auth()->user()->id;
                    $paymentReceipt->receipt_id = $charge->id;
                    $paymentReceipt->amount = 99.99;
                    $paymentReceipt->receipt_url = $charge->receipt_url;
                    $paymentReceipt->description = 'Subscription Fee';
                    $paymentReceipt->save();
    
                    session()->flash('success', 'Subscription purchased successfully.');
                    return [
                        'status'    =>  1,
                        'message'   =>  'Subscription purchased successfully.',
                    ];
                } else{
                    return [
                        'status'    =>  0,
                        'message'   =>  'Something went wrong.',
                    ];
                }
            } else{
                return [
                    'status'    =>  0,
                    'message'   =>  'Please add card.',
                ];
            }
        } catch (\Exception $exception){
            return [
                'status'     =>  0,
                'message'    =>  $exception->getMessage(),
            ];
        }
    }

    /** Set as default card */
    public function setAsDefaultCard(Request $request)
    {
        $this->validate($request , [
            'card_id'  =>  'required'
        ]);

        try{
            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);

            $updated = $stripe->customers->update(
                auth()->user()->customer_id,
                ['default_source' => $request->card_id]
            );

            if(isset($updated)){
                return [
                    'status'    =>  1,
                    'message'    =>  'Card set as default successfully.'
                ];
            }
            else{
                return [
                    'status'     =>  0,
                    'message'    =>  'Something went wrong.',
                ];
            }
        }catch (\Exception $exception){
            return [
                'status'     =>  0,
                'message'    =>  $exception->getMessage(),
            ];
        }
    }

    /** Get cards */
    public function getCards()
    {
        $stripe = new \Stripe\StripeClient($this->stripe_secret_key);

        $card_list = $stripe->customers->allSources(
            auth()->user()->customer_id,
            ['object' => 'card']
        );

        return $card_list;
    }

    /** Add card */
    public function addCard(Request $request)
    {
        $this->validate($request, [
            'card_holder_name'        =>  'required',
            'card_number'             =>  'required',
            'expiry_month_year'       =>  'required',
            'cvc'                     =>  'required'
        ]);

        try {
            $expiry_month_year = explode('/', $request->expiry_month_year);
            $month  = $expiry_month_year[0];
            $year = $expiry_month_year[1];

            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
            // Card token
            $card_token_response = $stripe->tokens->create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $month,
                    'exp_year' => $year,
                    'cvc' => $request->cvc
                ],
            ]);

            if (isset($card_token_response->error)) {
                return [
                    'status'    =>  0,
                    'message'   =>  $card_token_response->error->message
                ];
            } else {
                $card_create_response = $stripe->customers->createSource(
                    auth()->user()->customer_id,
                    ['source' => $card_token_response->id]
                );

                if (isset($card_create_response->error)) {
                    return [
                        'status'    =>  0,
                        'message'   =>  $card_create_response->error->message
                    ];
                } else {
                    session()->flash('success', 'Card added.');

                    return [
                        'status'        =>  1,
                        'message'       =>  'Card added successfully.'
                    ];
                }
            }
        } catch (\Exception $exception) {
            return [
                'status'     =>  0,
                'message'    =>  $exception->getMessage(),
            ];
        }
    }

    /** Delete card */
    public function deleteCard(Request $request)
    {
        $this->validate($request , [
            'card_id'  =>  'required'
        ]);

        try{
            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);

            $deleteResponse = $stripe->customers->deleteSource(
                auth()->user()->customer_id,
                $request->card_id,
                []
            );

            if(isset($deleteResponse->deleted)){
                return [
                    'status'    =>  1,
                    'message'   =>  'Card deleted successfully.'
                ];
            }
            else{
                return [
                    'status'     =>  0,
                    'message'    =>  'Something went wrong.'
                ];
            }
        }catch (\Exception $exception){
            return [
                'status'     =>  0,
                'message'    =>  $exception->getMessage(),
            ];
        }
    }
}   
