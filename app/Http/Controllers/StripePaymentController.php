<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Student;
use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('application_fee_payment.stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function afterPaymentLogin (Request $request)
    {
        $Student = Student::find($request->student_id);
        return view('application_fee_payment.afterpaymentloginform',compact('Student'));
    }


    public function stripePost(Request $request)
    {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $settings = Settings::orderBy('id','desc')->first();
        $Student = Student::find($request->student_id);
        $stripe->charges->create([
            'amount' => $settings->application_fee_for_institution*100,
            'currency' => 'INR',
            // 'destination' => 'acct_1H7zD8ALO10euUbD',
            //acct_1H7zD8ALO10euUbD   own account
            'source' => $request->stripeToken,
            'description' => $Student->student_name .' Paid the Fee for Application on '. date('d/m/Y'),
        ]);

        $stripe->charges->create([
            'amount' => 575*100,
            'currency' => 'INR',
            'destination' => 'acct_1H8jdLEyRxBPL1o4', // Secondary Account
            'source' => 'tok_visa',
            'description' => $Student->student_name .' Paid the Fee for Application on '. date('d/m/Y'),
        ]);

        // $Student = Student::find($request->student_id);
        $Student->application_fee_date = DATE("Y-m-d", STRTOTIME((date('Y').'+1 year')));
        $Student->status = 1;
        $Student->save();

        return redirect(route('paymentSuccess',$Student->id))->with('success', 'Payment was successfully added.!');
        // return $stripe->transfers->create([
        //     'amount' => 400,
        //     'currency' => 'inr',
        //     'destination' => 'acct_1H8jdLEyRxBPL1o4',
        //     'transfer_group' => 'ORDER_95',
        // ]);

        // $payment_intent = \Stripe\PaymentIntent::create([
        //     'payment_method_types' => ['card'],
        //     'amount' => 50*100,
        //     'currency' => 'INR',
        //     // 'transfer_data' => [
        //     //     'amount' => 100,
        //     //     'destination' => 'acct_1H8jdLEyRxBPL1o4',
        //     // ],
        // ]);

        // $stripe->transfers->create([
        //     'amount' => 40*100,
        //     'currency' => 'INR',
        //     // "source" => $request->stripeToken,
        //     'description' => 'My First Test Charge (created for API docs)',
        //     'destination' => 'acct_1H8jdLEyRxBPL1o4',
        // ]);

        // $stripe->transfers->create([
        //     'amount' => 500,
        //     'currency' => 'INR',
        //     // 'source' => 'tok_visa',
        //     'description' => 'My First Test Charge (created for API docs)',
        //     'destination' => 'acct_1H8q9NJGsStiP9s0',
        // ]);

        // $payment_intent = \Stripe\PaymentIntent::create([
        //     'payment_method_types' => ['card'],
        //     'amount' => 20000,
        //     'currency' => 'INR',
        //     'transfer_group' => 'ORDER10',
        //     'transfer_data' => [
        //       'amount' => 10000,
        //       'destination' => 'acct_1H8jdLEyRxBPL1o4',
        //     ],
        // ]);

        // dd($request->all());
        // $stripe->transfers->create([
        //     'amount' => 10000,
        //     'currency' => 'INR',
        //     'destination' => 'acct_1H8q9NJGsStiP9s0',
        //     'transfer_group' => 'ORDER_95',
        // ]);

        //Create a PaymentIntent:
        // $payment_intent = \Stripe\PaymentIntent::create([
        //     'payment_method_types' => ['card'],
        //     'amount' => 1000,
        //     'currency' => 'INR',
        //     // 'transfer_data' => [
        //     //   'amount' => 877,
        //     //   'destination' => 'acct_1H8q9NJGsStiP9s0',
        //     // ],
        //     'on_behalf_of' => 'acct_1H8q9NJGsStiP9s0'
        // ]);
        // return $payment_intent;
        // $paymentIntent = \Stripe\PaymentIntent::create([
        //     'amount' => 10000,
        //     'currency' => 'INR',
        //     'payment_method_types' => ['card'],
        //     'application_fee_amount' => 123,
        //     'transfer_data' => [
        //         'destination' => 'acct_1H8q9NJGsStiP9s0',
        //     ],
        //     'transfer_group' => '{ORDER10}',
        // ]);

        // Create a Transfer to a connected account (later):
        // $transfer = \Stripe\Transfer::create([
        //   'amount' => 7000,
        //   'currency' => 'INR',
        //   'destination' => 'acct_1H8jdLEyRxBPL1o4',
        // ]);

        // Create a second Transfer to another connected account (later):
        // $transfer = \Stripe\Transfer::create([
        //   'amount' => 2000,
        //   'currency' => 'inr',
        //   'destination' => '{{OTHER_CONNECTED_STRIPE_ACCOUNT_ID}}',
        //   'transfer_group' => '{ORDER10}',
        // ]);


        // $stripe->accounts->delete(
        //     'acct_1H8qW8FU2lXiEfrF',
        //     []
        // );

        // $account = \Stripe\Account::create([
        //     'country' => 'IN',
        //     'type' => 'custom',
        //     'requested_capabilities' => ['card_payments', 'transfers'],
        // ]);


        // // Create a PaymentIntent:
        // $paymentIntent = \Stripe\PaymentIntent::create([
        //     'amount' => 1000,
        //     'currency' => 'inr',
        //     'payment_method_types' => ['card'],
        //     'transfer_group' => 'ORDER10',
        // ]);

        // //Create a Transfer to a connected account (later):
        // $transfer = \Stripe\Transfer::create([
        //     'amount' => 500,
        //     'currency' => 'inr',
        //     'destination' => 'acct_1H8q9NJGsStiP9s0',
        //     'transfer_group' => 'ORDER10',
        // ]);

        // Create a second Transfer to another connected account (later):
        // $transfer = \Stripe\Transfer::create([
        //     'amount' => 10,
        //     'currency' => 'inr',
        //     'destination' => '{{OTHER_CONNECTED_STRIPE_ACCOUNT_ID}}',
        //     'transfer_group' => '{ORDER10}',
        // ]);

        // $stripe = new \Stripe\StripeClient(
        //     'sk_test_51H7zD8ALO10euUbDGY1V6CXVrcyieT6jE5jYy7OdCCCA2cIDzgdks0Nk9YPdISkG5LwpiwpCFUGozF0gZtmi43wR00qA8qIc45'
        // );
        // return $data = $stripe->accounts->create([
        //     'type' => 'custom',
        //     'country' => 'IN',
        //     'email' => 'vijayempiretest@gmail.com',
        //     'requested_capabilities' => [
        //         'card_payments',
        //       'transfers',
        //     ],
        // ]);

        // dd(response($data));

        // dd($request->all());


        // $payment_intent = \Stripe\PaymentIntent::create([
        //     'payment_method_types' => ['card'],
        //     'amount' => 1000,
        //     'currency' => 'inr',
        //     // 'transfer_data' => [
        //     //     'amount' => 40,
        //     //     'destination' => "acct_1H8TkXLC1LvoihBA",
        //     // ],
        // ], ['stripe_account' => 'acct_1H7zD8ALO10euUbD']);

        // $paymentIntent = \Stripe\PaymentIntent::create([
        //     'amount' => 50,
        //     'currency' => 'inr',
        //     'payment_method_types' => ['card'],
        //     // 'transfer_data' => [
        //     //     'amount' => 40,
        //     //     'destination' => "acct_1H7zD8ALO10euUbD",
        //     // ],
        //     'transfer_group' => 'ORDER10',
        // ]);

        // return $getId =  \Stripe\Transfer::create([
        //     'amount' => 7,
        //     'currency' => 'inr',
        //     'destination' => "acct_1H8TkXLC1LvoihBA",
        //     'transfer_group' => 'ORDER10',
        // ]);

        // return $stripe->transfers->create([
        //     'amount' => 400,
        //     'currency' => 'inr',
        //     'destination' => 'acct_1H7zD8ALO10euUbD',
        //     'transfer_group' => 'ORDER_95',
        // ]);

        // return $getId->id;
        // return $paymentIntent = \Stripe\PaymentIntent::create([
        //     'amount' => 50,
        //     'currency' => 'inr',
        //     'payment_method_types' => ['card'],
        //     // 'transfer_data' => [
        //     //     'amount' => 40,
        //     //     'destination' => "acct_1H8TkXLC1LvoihBA",
        //     // ],
        //     'transfer_group' => 'ORDER10',
        // ]);

        // return $transfer = \Stripe\Transfer::create([
        //     'amount' => 40,
        //     'currency' => 'inr',
        //     'destination' => 'acct_1H8TkXLC1LvoihBA',
        //     'transfer_group' => 'ORDER10',
        // ]);

        // //Create a second Transfer to another connected account (later):
        // $transfer = \Stripe\Transfer::create([
        //     'amount' => 2,
        //     // 'currency' => 'inr',
        //     'destination' => 'acct_1H8794FnceQY0Ri2',
        //     'transfer_group' => 'ORDER10',
        // ]);

        // dd($payment_intent);
    }
}
