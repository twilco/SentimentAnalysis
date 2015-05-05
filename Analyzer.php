<?php
/**
 * The main goal for this class is to implement several analysis methods to 
 * give a sentiment score to each of the tweets passed into it.
 */
class Analyzer()
{
    /**
     * The tweets being analyzed and scored.
     * @var array
     */
    $tweets = array();

    /**
     * The dictionary being used to score the tweets.
     * @var array
     */
    $dictionary = array();

    /**
     * Constructor to optionally allow initialization of $tweets and $dictionary
     * @param StringArray $tweets     Tweets being analyzed.
     * @param StringArray $dictionary Sentiment dictionary to utilize
     */
    public function __construct($tweets = NULL, $dictionary = NULL) {
        if(!is_null($tweets)) {
            $this->$tweets;
        }

        if(!is_null($dictionary)) {
            $this->$dictionary;
        }
    }

    /**
     * Sets new value for tweets.
     * @param StringArray $tweets New tweets to be analyzed
     */
    public function set_tweets($tweets) {
        $this->$tweets = $tweets;
    }

    /**
     * Sets new dictionary to score from.   
     * @param StringArray $dictionary Dictionary to score from.
     */
    public function set_dictionary($dictionary) {
        $this->$dictionary = $dictionary;
    }
}
?>