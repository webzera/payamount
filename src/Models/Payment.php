<?php

namespace Webzera\Payamount\Models;

use Illuminate\Database\Eloquent\Model;
use PayPal\Auth\OAuthTokenCredential; //for paypal apiContext
use PayPal\Rest\ApiContext;

class Payment extends Model
{
    protected $guarded = [];

    public $client_id;
    public $client_secret;
    
    private $apiContext = null;

    public function test($client_id, $client_secret){
        $this->client_id=$client_id;
        $this->client_secret=$client_secret;
        return $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($this->client_id, $this->client_secret)
          );
    }
}
