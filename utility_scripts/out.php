<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('max_execution_time', 1800);

require_once("/var/www/Sentiment_Analysis/TweetDataGenerator.php");
require_once("/var/www/Sentiment_Analysis/TweetSanitizer.php");
require_once("/var/www/Sentiment_Analysis/Dictionary.php");
require_once("/var/www/Sentiment_Analysis/Analyzer.php");
require_once("/var/www/Sentiment_Analysis/Database.php");
require_once("/var/www/Sentiment_Analysis/config.php");

$dictionary = array();
$tweet_sanitizer = new TweetSanitizer();
$tweet_data_generator = new TweetDataGenerator(get_oauth_settings());
$dictionary_inst = new Dictionary();
$sentiment_db = new Database(get_db_host(), get_db_username(), get_db_password(), "SENTIMENT_ANALYSIS");
$analyzer = new Analyzer();

//$sentiment_db->save_tweets($tweet_data_generator->sanitized_timeline_tweets_to_array("Sethrogen"));
echo $sentiment_db->db_tweets_to_json_file("/home/pi/test.json");
// $tweets = $tweet_sanitizer->file_read_tokenize_sanitize("/home/pi/twitter_data.txt", "~~~~");
//$dictionary = $dictionary_inst->read_LSD_dictionary("/var/www/Sentiment_Analysis/dictionary/LSD2011.txt", " ", "\n", "*");
// print_r($dictionary);

// $tweets = array(array());
//             $tweets[0]["twitter_id"] = 1111;
//             $tweets[0]["text"] = " 👍😘😃  ";
//             $tweets[0]["algo_score"] = 0;
//             $tweets[0]["baseline_score"] = 0;
//             $tweets[0]["has_algo_score"] = 0;
//             $tweets[0]["has_baseline_score"] = 0;
//             $tweets[0]["is_sanitized"] = 1;
    


// echo $sentiment_db->tweet_exists_by_id(1);




// $tweets = $tweet_data_generator->sanitized_timeline_tweets_to_array("Roedl3", 200);
// $analyzer->analyze_emojis($tweets);
// $analyzer->analyze_dictionary($tweets, $dictionary);
// for($i = 0; $i < count($tweets); $i++) {
//     echo 'SCORE: ' . $tweets[$i]["algo_score"] . '      -----------------  TEXT: ' . $tweets[$i]["text"] . '<br>';
// }







//echo $sentiment_db->save_tweets($tweets);

//print_r($sentiment_db->text_of_all_sanitized_tweets());

// echo "<pre>";
// print_r($tweets);