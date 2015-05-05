<?php

require_once("/car/www/Sentiment_Analysis/TweetSanitizer.php");

class Database
{
    private $connection = "";

    /**
     * Database constructor that allows you to connect to a database upon object creation.
     * @param String $host     Host to connect to
     * @param String $username Username to authenticate with
     * @param String $password Password to authenticate with
     * @param String $database Database to connect to
     */
    public function __construct($host = NULL, $username = NULL, $password = NULL, $database = NULL)
    {
        if(!is_null($host) && !is_null($username) && !is_null($password) && !is_null($database)) {
            $this->connect_to_db($host, $username, $password, $database);
        }
    }

    /**
     * Establishes connection to the specified MySQL database and stores this
     * connection in the $connection class variable to be used later.
     * @param  String $host     Host to connect to
     * @param  String $username Username to authenticate with
     * @param  String $password Password to authenticate with
     * @param  String $database Database to connect to
     */
    public function connect_to_db($host, $username, $password, $database) 
    {
        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
    } 

    /**
     * Returns the current connection stored in the class.
     * @return DBConnection Current database connection.
     */
    public function get_connection()
    {
        return $this->connection();
    }

    /**
     * Checks to see if the passed in variable is currently connected to a MySQL database.
     * @param  DB_Connection $db_connection The connection to test
     * @return boolean                      Returns true if it is connected, false otherwise
     */
    public function is_connected($db_connection)
    {
        if($db_connection->ping() !== false) {
            return true;
        }
        return false;
    }

    /**
     * Saves tweets into the database.
     * @param  array            Array containing tweets to insert into the database.
     * @return Boolean          True if successful, false if not connected or otherwise unsuccessful
     */
    public function save_new_tweets($tweets)
    {
        if($this->is_connected($this->connection)) {
            foreach($tweets as $tweet) {
                $insert_query = "INSERT INTO `Tweets`(`twitter_id`, `text`, `algo_score`, `has_algo_score`, `baseline_score`, `has_baseline_score`, `is_sanitized`)
                                 VALUES (?, ?, ?, ?, ?, ?, ?)";

                $prepared_query = mysqli_prepare($this->connection, $insert_query);
                if(!$prepared_query) {
                    die("Mysqli error:" . mysql_error($this->connection));
                }

                //Bind the parameters into the query
                mysqli_stmt_bind_param($prepared_query, 'sssssss', $tweet["twitter_id"], $tweet["text"], $tweet["algo_score"], $tweet["has_algo_score"], $tweet["baseline_score"], $tweet["has_baseline_score"], $tweet["is_sanitized"]);

                //Run the query
                mysqli_execute($prepared_query) or die(mysqli_error($this->connection));
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sanitizes the tweets passed to it, and then saves them to the database.
     * @param  array $tweets  Associative array of tweets
     * @return Boolean        True if successful, false if not connected to the database or other errors
     */
    public function sanitize_and_save_new_tweets($tweets)
    {
        $tweet_sanitizer = new TweetSanitizer();
        for($i = 0; $i < count($tweets); $i++) {
            $tweets[$i]['text'] = $tweet_sanitizer->complete_sanitization($tweets[$i]['text']);
            $tweets[$i]['is_sanitized'] = 1;
        }
        return $this->save_new_tweets($tweets);
    }

    public function sanitize_tweet($id = NULL, $tweet_id = NULL) 
    {
        if(is_null($id)) {
            //they want to sanitize based on specific tweet_id
            if($this->is_connected($this->connection)) {

            } else {
                return false;
            }
        } else if(is_null($tweet_id)) {
            //they want to sanitize based on specific table id
            if($this->is_connected($this->connection)) {

            } else {
                return false;
            }
        } else {
            //they didn't pass any parameters in
            return false;
        }
    }

    /**
     * Sanitizes all unsanitized tweets.
     * @return [type] [description]
     */
    public function sanitize_all_tweets()
    {
        if($this->is_connected($this->connection)) {

        }
    }

    /**
     * Sanitize all tweets, even those already marked as sanitized.
     * @return [type] [description]
     */
    public function resanitize_all_tweets()
    {
        if($this->is_connected($this->connection)) {

        }
    }
}

?>