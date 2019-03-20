<?php

namespace Webzera\Payamount\Http\Controllers;

use App\Http\Controllers\Controller;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use PayPal\Api\PaymentExecution;

use Webzera\Payamount\Models\Payment as Locpayment;


class PaymentController extends Controller
{
    public function index(){       
        return view('payamount::paybutton');
    }
    public function create(){
        $locpayment = new Locpayment();
        $apiContext=$locpayment->test(config('paycredentials.paypal.id'), config('paycredentials.paypal.secret'));

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice(7.5);

        $item2 = new Item();
        $item2->setName('Granola bars')
            ->setCurrency('USD')
            ->setQuantity(5)
            ->setSku("321321") // Similar to `item_number` in Classic API
            ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));

        $details = new Details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.50);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(config('paycredentials.paypal.ret-success'))
            ->setCancelUrl(config('paycredentials.paypal.ret-cancel'));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($apiContext);

        $approvalUrl = $payment->getApprovalLink();

        $getoken=explode('&', $approvalUrl);
        $getoken=explode('=', $getoken[1]);
        $getoken=$getoken[1]; //get token from url        

        //dd($payment->id);
        $locpayment = new Locpayment();
        $locpayment->user_id=1;
        $locpayment->pay_token=$getoken;
        $locpayment->payment_id=$payment->id;
        $locpayment->payable_amt=20;
        $locpayment->payment_type=2;
        $locpayment->payment_status='0';
        $locpayment->save();

        return redirect($approvalUrl);
    }
    public function excute(){

        $locpayment = new Locpayment();
        $apiContext=$locpayment->test(config('paycredentials.paypal.id'), config('paycredentials.paypal.secret'));

        $paymentId=request('paymentId');  //payment id
        $gettoken=$_GET['token'];
        $payerId=$_GET['PayerID'];  

        $locpayment=Locpayment::where(['payment_id' => $paymentId,'pay_token' => $gettoken])->first();

        $locpayment->payer_id=$payerId;
        $locpayment->payment_status='1';

        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        // $transaction = new Transaction();
        // $amount = new Amount();

        // $details = new Details();
        // $details->setShipping(2.2)
        //     ->setTax(1.3)
        //     ->setSubtotal(17.50);

        // $amount->setCurrency('USD');
        // $amount->setTotal(21);
        // $amount->setDetails($details);
        // $transaction->setAmount($amount);

        // $execution->addTransaction($transaction);

        try{
            $result = $payment->execute($execution, $apiContext);
        } catch (Exception $e) {
            $data = json_decode($e->getData());            
            echo $data->message;
            die();
        }  

        $result->id; //payment id
        $locpayment->invoice_id=$result->transactions[0]->invoice_number; //invoice no
        $locpayment->save();

        return redirect('/')->with('success', 'Your Amount Paid Successfully, Thanks. Check your Orders');
    }    
    public function cancel(){
    $ret_token=$_GET['token'];
    echo $ret_token; echo "transaction canceled packages";
    }
}