oauth-v1
========

All in one oauth script.


#Example


<pre>
&lt;?php
include "./oauth.php";
$config = array();
$config['consumer_key'] = 'CHANGEME_CONSUMER_KEY';
$config['consumer_signature_method']= 'HMAC-SHA1';
$config['consumer_secret'] = 'CHANGEME_CONSUMER_SECRET';
$config['timestamp'] = $_SERVER['REQUEST_TIME'];

$token='CHANGEME_TOKEN';
$token_secret='CHANGEME_TOKEN_SECRET';

$url = 'https://api.twitter.com/1.1/account/settings.json';


$consumer_key = $config["consumer_key"];
$consumer_signature_method = 'HMAC-SHA1';
$consumer_secret = $config['consumer_secret'];

$params = array
(
    'oauth_consumer_key' => $consumer_key,
    'oauth_signature_method' => $consumer_signature_method,
    'oauth_signature' => '',
    'oauth_version' => "1.0"
);


$sig_method = new OAuthSignatureMethod_HMAC_SHA1();




$test_token = new OAuthConsumer($token, $token_secret);
$test_consumer = new OAuthConsumer($consumer_key, $consumer_secret, NULL);

$acc_req = OAuthRequest::from_consumer_and_token($test_consumer, $test_token, "GET", $url, $params);
$acc_req->sign_request($sig_method, $test_consumer, $test_token);

$url=$acc_req;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HEADER, false );
$html = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
print_r($info);
print_r($html);
</pre>
