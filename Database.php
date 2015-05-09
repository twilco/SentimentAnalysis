<?php

require_once("/var/www/Sentiment_Analysis/TweetSanitizer.php");

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
        } 
        return false;
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

    /**
     * Sanitizes the specified tweet based on the table ID.
     * @param  Integer $id       ID of the tweet in the table
     * @return Boolean           True if successful, false if unsuccessful
     */
    public function sanitize_tweet_by_id($id) 
    {
        $tweet_sanitizer = new TweetSanitizer();
        if($this->is_connected($this->connection)) {
            $tweet_text = $this->text_of_tweet_by_id($id);
            $sanitized_text = $tweet_sanitizer->complete_sanitization($tweet_text);

            if($update_statement = $this->connection->prepare("UPDATE Tweets SET text = ?, is_sanitized = 1 WHERE id = ?")) {
                $update_statement->bind_param("ss", $sanitized_text, $id);
                $update_statement->execute();
                $update_statement->close();
                return true;
            }
            return false;
        } 
        return false;
    }

    /**
     * Sanitizes the specified tweet based on the ID of the tweet assigned by Twitter.
     * @param  Integer $twitter_id ID of the tweet assigned by Twitter
     * @return Boolean             True if successful, false if unsuccessful
     */
    public function sanitize_tweet_by_twitter_id($twitter_id)
    {
        $tweet_sanitizer = new TweetSanitizer();
        if($this->is_connected($this->connection)) {
            $tweet_text = $this->text_of_tweet_by_twitter_id($twitter_id);
            $sanitized_text = $tweet_sanitizer->complete_sanitization($tweet_text);

            if($update_statement = $this->connection->prepare("UPDATE Tweets SET text = ?, is_sanitized = 1 WHERE twitter_id = ?")) {
                $update_statement->bind_param("ss", $sanitized_text, $twitter_id);
                $update_statement->execute();
                $update_statement->close();
                return true;
            }
            return false;
        } 
        return false;
    }

    /**
     * Grabs the text of the tweet specified by the passed in table ID.
     * @param  Integer $id Table ID to choose the tweet by
     * @return String      Text of the tweet selected or false if there is no database connection
     */
    public function text_of_tweet_by_id($id)
    {
        if($this->is_connected($this->connection)) {
            $select_statement = $this->connection->prepare("SELECT text
                                                            FROM Tweets
                                                            WHERE id = ?");
            $select_statement->bind_param("s", $id);
            $select_statement->execute();
            $select_statement->bind_result($text);
            while($select_statement->fetch()) {            
                $select_statement->close();
                return $text;
            }

        }
        return false;
    }

    /**
     * Grabs the text of the tweet specified by ID assigned to that tweet by Twitter.
     * @param  Integer $twitter_id ID of the tweet assigned by Twitter
     * @return String              Text of the tweet selected or false if there is no database connection
     */
    public function text_of_tweet_by_twitter_id($twitter_id)
    {
        if($this->is_connected($this->connection)) {
            $select_statement = $this->connection->prepare("SELECT text
                                                            FROM Tweets
                                                            WHERE twitter_id = ?");
            $select_statement->bind_param("s", $twitter_id);
            $select_statement->execute();
            $select_statement->bind_result($text);
            while($select_statement->fetch()) {
                $select_statement->close();
                return $text;
            }
            
        } 
        return false;
    }

    /**
     * Check to see if a tweet exists in the database, searching by the id assigned to the tweet by the Tweets table auto increment.
     * @param  Integer $id    ID of the tweet assigned by the Tweets table auto increment
     * @return Boolean        True if the tweet already exists in the database, false if it doesn't or you aren't connected to the database.
     */
    public function tweet_exists_by_id($id)
    {
        if($this->is_connected($this->connection)) {
            $select_statement = $this->connection->prepare("SELECT text
                                                            FROM Tweets
                                                            WHERE id = ?");
            $select_statement->bind_param("s", $id);
            $select_statement->execute();
            $select_statement->store_result();
            if($select_statement->num_rows() == 0) {
                return false;
            }
            return true;
        } 
        return false;
    }

    /**
     * Check to see if a tweet exists in the database, searching by the id assigned to the tweet by Twitter.
     * @param  Integer $twitter_id ID of the tweet assigned by Twitter
     * @return Boolean             True if the tweet already exists in the database, false if it doesn't or you aren't connected to the database.
     */
    public function tweet_exists_by_twitter_id($twitter_id)
    {
        if($this->is_connected($this->connection)) {
            $select_statement = $this->connection->prepare("SELECT text
                                                            FROM Tweets
                                                            WHERE twitter_id = ?");
            $select_statement->bind_param("s", $twitter_id);
            $select_statement->execute();
            $select_statement->store_result();
            if($select_statement->num_rows() == 0) {
                return false;
            }
            return true;
            
        } 
        return false;
    }

    /**
     * Gets the text of all tweets in the database, sanitized or unsanitized.
     * @return array An array of the text of all tweets in the database.
     */
    public function text_of_all_tweets()
    {
        if($this->is_connected($this->connection)) {
            $return_array = array();
            $select_statement = $this->connection->prepare("SELECT id, text
                                                            FROM Tweets");
            $select_statement->execute();
            $select_statement->bind_result($id, $text);
            $counter = 0;
            while($select_statement->fetch()) {
                $return_array[$counter++]["text"] = $text;
                $return_array[$counter++]["id"] = $id;
            }
            $select_statement->close();
            return $return_array;
        } 
        return false;
    }

    /**
     * Gets the text of all sanitized tweets in the database.
     * @return array Text of all sanitized tweets
     */
    public function text_of_all_sanitized_tweets()
    {
        if($this->is_connected($this->connection)) {
            $return_array = array();
            $select_statement = $this->connection->prepare("SELECT id, text
                                                            FROM Tweets
                                                            WHERE is_sanitized = 1");
            $select_statement->execute();
            $select_statement->bind_result($id, $text);
            $counter = 0;
            while($select_statement->fetch()) {
                $return_array[$counter++]["text"] = $text;
                $return_array[$counter++]["id"] = $id;
            }
            $select_statement->close();
            return $return_array;
        } 
        return false;
    }

    /**
     * Gets the text of all unsanitized tweets in the database.
     * @return array Text of all unsanitized tweets
     */
    public function text_of_all_unsanitized_tweets()
    {
        if($this->is_connected($this->connection)) {
            $return_array = array();
            $select_statement = $this->connection->prepare("SELECT id, text
                                                            FROM Tweets
                                                            WHERE is_sanitized = 0");
            $select_statement->execute();
            $select_statement->bind_result($id, $text);
            $counter = 0;
            while($select_statement->fetch()) {
                $return_array[$counter++]["text"] = $text;
                $return_array[$counter++]["id"] = $id;
            }
            $select_statement->close();
            return $return_array;
        } 
        return false;
    }

    /**
     * Sanitizes all unsanitized tweets.
     * @return Boolean True if the operation was successful, false if it wasn't
     */
    public function sanitize_all_tweets()
    {
        if($this->is_connected($this->connection)) {
            $tweets = $this->text_of_all_unsanitized_tweets();
            for($i = 0; $i < count($tweets); $i++) {
                $tweets["text"] = $this->sanitize_tweet_by_id($tweets["id"]);
            }
            return true;
        }
        return false;
    }   

    /**
     * Sanitize all tweets, even those already marked as sanitized.
     * @return Boolean True if the operation was successful, false if it wasn't
     */
    public function resanitize_all_tweets()
    {
        if($this->is_connected($this->connection)) {
            $tweets = $this->text_of_all_tweets();
            for($i = 0; $i < count($tweets); $i++) {
                $tweets["text"] = $this->sanitize_tweet_by_id($tweets["id"]);
            }
            return true;
        }
        return false;
    }
}

?>