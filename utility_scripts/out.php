<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once("../SentimentAnalysis/TweetSanitizer.php");
require_once("../SentimentAnalysis/Dictionary.php");
require_once("../SentimentAnalysis/TweetFileGenerator.php")
require_once('../SentimentAnalysis/config.php');

$dictionary = array();
$tweet_sanitizer = new TweetSanitizer();
$dictionary_inst = new Dictionary();

$tweets = $tweet_sanitizer->read_tokenize_sanitize("/home/pi/twitter_data.txt", "~~~~");
$dictionary = $dictionary_inst->read_LSD_dictionary("../Sentiment_Analysis/dictionary/LSD2011.txt", " ", "\n", "*");

for($i = 0; $i < count($tweets); $i++) {
    
}

echo "<pre>";
print_r($dictionary);