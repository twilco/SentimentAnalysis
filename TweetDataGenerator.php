<?php
require_once('../SentimentAnalysis/twitter-api-php-master/TwitterAPIExchange.php');
/**
 * This class contains functions that can generate a file of tweets.
 */
class TweetDataGenerator()
{
    /**
     * Settings to connect to Twitter's API.
     * @var array
     */
    $settings = array();

    public function __construct($settings) {
        $this->$settings = $settings;
    }

    /**
     * Setter for $settings
     * @param StringArray $new_settings New settings for the connection to Twitter's API
     */
    public function set_settings($new_settings) {
        $this->$settings = $new_settings;
    }

    /**
     * Grabs tweets, up to a maximum of 200 (limit imposed by Twitter API), from the specified
     * user's timeline and writes them to the passed in file.  If the file isn't already created,
     * it will create it for you.  If it does exist, it will append it to the end of the file
     * @param  String  $file_path       File to write to
     * @param  String  $username        Twitter username to grab tweets from
     * @param  String  $tweet_delimiter What to delimit each tweet by
     * @param  Integer $tweet_count     How many tweets to grab (note that the max is 200 per function call, a limit imposed by Twitter's API)
     */
    public function timeline_tweets_to_file($file_path, $username, $tweet_delimiter, $tweet_count = NULL) {
        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
        $request_method = "GET";
        $get_field = "";

        if(is_null($tweet_count)) {
            $get_field = '?screen_name='.$username.'&count=200&trim_user=true';
        } else if(is_numeric($tweet_count)) {
            $get_field = '?screen_name='.$username.'&count='.$tweet_count.'&trim_user=true';
        } else {
            exit("Unexpected value received for $tweet_count in function timeline_tweets_to_file: " . $tweet_count);
        }
         
        $twitter = new TwitterAPIExchange($this->$settings);
        $tweets = array();
        $raw_tweet_data = $twitter->setGetfield($get_field)
                                  ->buildOauth($url, $request_method)
                                  ->performRequest();

        $raw_tweet_data = json_decode($raw_tweet_data);
        $out_string = "";

        for($i = 0; $i < count($raw_tweet_data); $i++) {
            if($raw_tweet_data[$i]->lang == "en") {
                $out_string .= $tweet_delimiter . $raw_tweet_data[$i]->text;
            }
        }

        file_put_contents($file_path, $out_string, FILE_APPEND | LOCK_EX);
    }

    //timeline_tweets_to_db()
    //change name of class to TweetDataGenerator
}