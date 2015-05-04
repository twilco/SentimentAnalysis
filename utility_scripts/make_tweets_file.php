<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('../SentimentAnalysis/TweetFileGenerator.php');
require_once('../SentimentAnalysis/config.php');

$tweet_file_generator = new TweetFileGenerator($get_oauth_settings());

$tweet_file_generator->timeline_tweets_to_file("/home/pi/tweets.txt", "Sethrogen", "~~~~", 200);

?>