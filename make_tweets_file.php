<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('../Sentiment_Analysis/twitter-api-php-master/TwitterAPIExchange.php');
require_once('../Sentiment_Analysis/config.php');

$settings = array(
    'oauth_access_token' => $oauth_access_token,
    'oauth_access_token_secret' => $oauth_access_token_secret,
    'consumer_key' => $consumer_key,
    'consumer_secret' => $consumer_secret
);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

$request_method = "GET";
 
$get_field = '?screen_name=Sethrogen&count=200&trim_user=true';
 
$twitter = new TwitterAPIExchange($settings);
$tweets = array();
$raw_tweet_data = $twitter->setGetfield($get_field)
                          ->buildOauth($url, $request_method)
                          ->performRequest();

$raw_tweet_data = json_decode($raw_tweet_data);
$out_string = "";

for($i = 0; $i < count($raw_tweet_data); $i++) {
    if($raw_tweet_data[$i]->lang == "en") {
        $out_string .= "~~~~" . $raw_tweet_data[$i]->text;
    }
}

file_put_contents("/home/pi/tweets.txt", $out_string, FILE_APPEND | LOCK_EX);
