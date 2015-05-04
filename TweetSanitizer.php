<?php
/**
 * This class contains functions that sanitize unneeded information from tweets 
 * before they go to the sentiment analysis step.
 * @todo Check for blank tweets
 */
class TweetSanitizer
{
    /**
     * Removes all URLs from the input.
     * @param  String/String array $input The String to strip URLs from.
     * @return String/String array        The newly modified String/String array.
     */
    public function remove_urls($input)
    {
        return preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $input);
    }

    /**
     * Removes any instance of "RT" from the input.
     * @param  String/String array $input The String to strip "RT" from.
     * @return String/String array        The newly modified String/String array.
     */
    public function remove_RT($input)
    {
        return str_replace("RT", "", $input);
    }

    /**
     * Removes any username following the @username pattern.
     * @param  String/String array $input The String to strip usernames from.
     * @return String/String array        The newly modified String/String array.
     */
    public function remove_usernames($input)
    {
        return preg_replace('/(\s+|^)@\S+/', '', $input);
    }

    /**
     * Runs all sanitization functions.
     * @param  String/String array $input The String being sanitized.
     * @return String/String array        The newly modified String/String array.
     */
    public function complete_sanitization($input)
    {
        return $this->remove_urls($this->remove_RT($this->remove_usernames($input)));
    }

    /**
     * Reads and tokenizes the specified file.  
     * @param  String $file_dir  The file being read and tokenized
     * @param  String $delimiter Delimiter to tokenize by
     * @return String array      Array of tokens gathered from the input file.
     */
    public function read_and_tokenize($file_dir, $delimiter)
    {
        if(is_string($file_dir)) {
            $file_string = file_get_contents($file_dir);
            return explode($delimiter, $file_string);
        }
        return false;
    }

    /**
     * Reads, tokenizes, and sanitizes the specified file.
     * @param  String $file_dir   The file being read, tokenized, and sanitized
     * @param  String $delimiter Delimiter to tokenize by
     * @return String array      Array of sanitized tokens gathered from the input file.
     */
    public function read_tokenize_sanitize($file_dir, $delimiter)
    {
        if(is_string($file_dir)) {
            $file_string = file_get_contents($file_dir);
            $tokenized_tweets = explode($delimiter, $file_string);
            return $this->complete_sanitization($tokenized_tweets);
        }
        return false;
    }
}
?>