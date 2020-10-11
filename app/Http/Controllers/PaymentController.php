<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal;

use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
// use PayPal\Auth\OAuthTokenCredential;
// use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Auth;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaymentController extends Controller
{
    /**
     * @var ApiContext
     */
    private $_api_context;

    /**
     * PaymentController constructor.
     */
    public function __construct()
    {

        $paypal_conf = config('paypal');
        $this->_api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret']
            )
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function paypalCallback()
    {
        if (!empty(request('paymentId'))) {
            $paymentId = request('paymentId');
            $payment = Payment::get($paymentId, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId(request('PayerID'));
            try {
                $result = $payment->execute($execution, $this->_api_context);
                try {
                    $payment = Payment::get($paymentId, $this->_api_context);
                } catch (\Exception $ex) {
                    return route('cart.show', [
                        'message' => 'Couldn\'t proceed your payment'
                    ]);
                }
            } catch (\Exception $ex) {
                return route('cart.show', [
                    'message' => $ex
                ]);
            }
            Auth::user()->cart->delete();
            return view('payment-success', [
                'payment_id' => $payment->getId(),
                'state' => $payment->getState(),
                'failure_reason' => $payment->getFailureReason(),
            ]);
        }

        return view('cart', [
            'message' => 'User Cancelled the Approval'
        ]);
    }

    public function payWithPaypal()
    {

        // TODO: add validation of amount being decimal and other validation rules

        $price = number_format(\request('amount'));
        $quantity = 1;
        $currency = 'USD';
        $itemName = 'Product';
        $transactionDescription = 'Product';

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item1 = new Item();
        $item1->setName($itemName)
            ->setCurrency($currency)
            ->setQuantity($quantity)
            ->setPrice($price);

        $item_list = new ItemList();
        $item_list->setItems([$item1]);

        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($transactionDescription);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('paypal.payment.status'))
            ->setCancelUrl(route('paypal.payment.cancel'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\Exception $ex) {

            return redirect(route('cart.show', [
                'message' => 'User Cancelled the Approval'
            ]));
        }

        $approvalUrl = $payment->getApprovalLink();
        return Redirect::away($approvalUrl);
    }
}
