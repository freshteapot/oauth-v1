<?php
/**
 * How to run:
 * - Change all variables which start with CHANGEME_
 * - php talk.to.twitter.php
 * 
 * If all goes well and you get a json response.
 *
 * //Outputs a well formatted json object.
 * php talk.to.twitter.php | python -mjson.tool
 *
 */
include "../oauth.php";

//Basic Config settings
$config = array();
$config['consumer_key'] = 'CHANGEME_CONSUMER_KEY';
$config['consumer_signature_method']= 'HMAC-SHA1';
$config['consumer_secret'] = 'CHANGEME_CONSUMER_SECRET';
$config['timestamp'] = $_SERVER['REQUEST_TIME'];

/*
 * This should be stored somewhere.
 * If you are using twitter, then at least you should have access to something via
 * dev.twitter.com
 */
$token='CHANGEME_TOKEN';
$token_secret='CHANGEME_TOKEN_SECRET';

//Im going to use settings, as it will prove the code.
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

//As mentioned in the config, we will be using HMAC_SHA1.
$sig_method = new OAuthSignatureMethod_HMAC_SHA1();

$test_token = new OAuthConsumer($token, $token_secret);
$test_consumer = new OAuthConsumer($consumer_key, $consumer_secret, NULL);

//It is important to make sure you send the correct http request.
$acc_req = OAuthRequest::from_consumer_and_token($test_consumer, $test_token, "GET", $url, $params);
$acc_req->sign_request($sig_method, $test_consumer, $test_token);

//Our url will now include the extra parameters required.
$url = $acc_req;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HEADER, false );
$html = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
//If you are curious about the info uncomment the line below
//print_r($info);
echo $html;
