<?php
/**
 * The main goal for this class is to implement several analysis methods to 
 * give a sentiment score to each of the tweets passed into it.
 */
class Analyzer
{
    /**
     * The tweets being analyzed and scored.
     * @var array
     */
    private $tweets = array();

    /**
     * The dictionary being used to score the tweets.
     * @var array
     */
    private $dictionary = array();

    /**
     * Constructor to optionally allow initialization of $tweets and $dictionary
     * @param StringArray $tweets     Tweets being analyzed.
     * @param StringArray $dictionary Sentiment dictionary to utilize
     */
    public function __construct($tweets = NULL, $dictionary = NULL) 
    {
        if(!is_null($tweets)) {
            $this->tweets;
        }

        if(!is_null($dictionary)) {
            $this->dictionary;
        }
    }

    /**
     * Sets new value for tweets.
     * @param StringArray $tweets New tweets to be analyzed
     */
    public function set_tweets($tweets) 
    {
        $this->tweets = $tweets;
    }

    /**
     * Sets new dictionary to score from.   
     * @param StringArray $dictionary Dictionary to score from.
     */
    public function set_dictionary($dictionary) 
    {
        if(is_array($dictionary)) {
            $this->dictionary = $dictionary;
        } else {
            exit("Expected array in Analyzer.php's set_dictionary method, got: " . $dictionary);
        }
    }

    /**
     * Returns the dictionary class variable.
     * @return StringArray Sentiment dictionary to score tweets from
     */
    public function get_dictionary()
    {
        if(empty($this->dictionary)) {
            exit("Dictionary not set before Analyzer.php's get_dictionary() call.");
        }
        return $this->dictionary;
    }

    /**
     * Performs all analysis operations on the passed in (by reference) tweets.
     * @param  StringArray &$tweets Tweets, passed in by reference, which get their sentiment score modified
     */
    public function complete_analyzation(&$tweets)
    {
        $this->analyze_emojis($tweets);
        $this->analyze_dictionary($tweets);
    }

    /**
     * Performs a dictionary analysis on the passed in tweets, increasing sentiment score for postive words
     * and decreasing sentiment score for negative words.
     * @param  StringArray &$tweets Tweets, passed in by reference, which get their sentiment score modified
     * @param  StringArray $dictionary Optional parameter which sets the dictionary to use in the class variable $dictionary
     */
    public function analyze_dictionary(&$tweets, $dictionary = NULL)
    {
        if(!is_null($dictionary)) {
            $this->set_dictionary($dictionary);
        }

        $dictionary = $this->get_dictionary();

        for($i = 0; $i < count($tweets); $i++) {
            for($j = 0; $j < count($dictionary); $j++) {
                
            }
        }
    }

    /**
     * Assigns score based on the presence of certain emojis. 
     * @param  array &$tweets  Tweets to analyze 
     */
    public function analyze_emojis(&$tweets)
    {
        $this->analyze_positive_emojis($tweets);
        $this->analyze_negative_emojis($tweets);
    }

    /**
     * Increases sentiment score based on the presence of certain emojis.
     * The comment descriptions are exactly as they appear on this website:
     * http://www.iemoji.com/
     * @param  array &$tweets  Tweets to analyze 
     */
    public function analyze_positive_emojis(&$tweets)
    {
        for($i = 0; $i < count($tweets); $i++) {
            //face with tears of joy
            if(strpos($tweets[$i]["text"], strval(😂))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //smiling face with open mouth and smiling eyes
            if(strpos($tweets[$i]["text"], strval(😄))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //smiling face with open mouth
            if(strpos($tweets[$i]["text"], strval(😃))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //grinning mouth
            if(strpos($tweets[$i]["text"], strval(😀))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //smiling face with smiling eyes
            if(strpos($tweets[$i]["text"], strval(😊))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //white smiling face
            if(strpos($tweets[$i]["text"], strval(☺)) !== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //winking face
            if(strpos($tweets[$i]["text"], strval(😉))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }    

            //smiling face with heart shaped eyes
            if(strpos($tweets[$i]["text"], strval(😍)) !== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }        

            //face throwing a kiss
            if(strpos($tweets[$i]["text"], strval(😘)) !== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //kissing face with closed eyes
            if(strpos($tweets[$i]["text"], strval(😚)) !== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //kissing face
            if(strpos($tweets[$i]["text"], strval(😗))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //kissing face with smiling eyes
            if(strpos($tweets[$i]["text"], strval(😙))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //relieved face
            if(strpos($tweets[$i]["text"], strval(😌))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //smiling face with open mouth and tightly closed eyes
            if(strpos($tweets[$i]["text"], strval(😆))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            


            //face savoring delicious food
            if(strpos($tweets[$i]["text"], strval(😋))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //smiling face with sunglasses
            if(strpos($tweets[$i]["text"], strval(😎))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //smiling face with halo
            if(strpos($tweets[$i]["text"], strval(😇))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //smirking face
            if(strpos($tweets[$i]["text"], strval(😏))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //man with gua pi mao
            if(strpos($tweets[$i]["text"], strval(👲))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //man with turban
            if(strpos($tweets[$i]["text"], strval(👳))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //baby
            if(strpos($tweets[$i]["text"], strval(👶))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //boy
            if(strpos($tweets[$i]["text"], strval(👦))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //girl
            if(strpos($tweets[$i]["text"], strval(👧))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //person with blond hair
            if(strpos($tweets[$i]["text"], strval(👱))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //smiling cat face with open mouth
            if(strpos($tweets[$i]["text"], strval(😺))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //smiling cat face with heart shaped eyes
            if(strpos($tweets[$i]["text"], strval(😻))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //kissing cat face with closed eyes
            if(strpos($tweets[$i]["text"], strval(😽))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //thumbs up
            if(strpos($tweets[$i]["text"], strval(👍))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //kiss mark
            if(strpos($tweets[$i]["text"], strval(💋))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //thumbs up
            if(strpos($tweets[$i]["text"], strval(👍))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //love letter
            if(strpos($tweets[$i]["text"], strval(💌))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //heart with arrow
            if(strpos($tweets[$i]["text"], strval(💘))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //revolving hearts
            if(strpos($tweets[$i]["text"], strval(💞))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //sparkling heart
            if(strpos($tweets[$i]["text"], strval(💖))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //two hearts
            if(strpos($tweets[$i]["text"], strval(💕))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //beating heart
            if(strpos($tweets[$i]["text"], strval(💓))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }            

            //growing heart
            if(strpos($tweets[$i]["text"], strval(💗))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //heavy black heart (picture is red though)
            if(strpos($tweets[$i]["text"], strval(❤))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //green heart
            if(strpos($tweets[$i]["text"], strval(💚))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //purple heart
            if(strpos($tweets[$i]["text"], strval(💜))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //blue heart
            if(strpos($tweets[$i]["text"], strval(💙))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //yellow heart
            if(strpos($tweets[$i]["text"], strval(💛))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //bride with veil
            if(strpos($tweets[$i]["text"], strval(👰))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //hair cut
            if(strpos($tweets[$i]["text"], strval(💇))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //couple with heart
            if(strpos($tweets[$i]["text"], strval(💑))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //kiss
            if(strpos($tweets[$i]["text"], strval(💏))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //family
            if(strpos($tweets[$i]["text"], strval(👪))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //man and woman holding hands
            if(strpos($tweets[$i]["text"], strval(👫))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }

            //cat face with tears of joy
            if(strpos($tweets[$i]["text"], strval(😹))!== false) {
                $tweets[$i]["algo_score"]++;
                $tweets[$i]["has_algo_score"] = 1;
            }
        }
    }

    /**
     * Decreases sentiment score based on the presence of certain emojis.
     * The comment descriptions are exactly as they appear on this website:
     * http://www.iemoji.com/
     * @param  array &$tweets  Tweets to analyze 
     */
    public function analyze_negative_emojis(&$tweets)
    {
        //pensive face
        if(strpos($tweets[$i]["text"], strval(😔))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        


        //unamused face
        if(strpos($tweets[$i]["text"], strval(😒))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //disappointed face
        if(strpos($tweets[$i]["text"], strval(😞))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //persevering face
        if(strpos($tweets[$i]["text"], strval(😣))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //crying face
        if(strpos($tweets[$i]["text"], strval(😢))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //loudly crying face
        if(strpos($tweets[$i]["text"], strval(😭))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //disappointed but relieved face
        if(strpos($tweets[$i]["text"], strval(😥))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //face with open mouth and cold sweat
        if(strpos($tweets[$i]["text"], strval(😰))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //face with cold sweat
        if(strpos($tweets[$i]["text"], strval(😓))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //weary face
        if(strpos($tweets[$i]["text"], strval(😩))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //angry face
        if(strpos($tweets[$i]["text"], strval(😠))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //pouting face
        if(strpos($tweets[$i]["text"], strval(😡))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //confounded face
        if(strpos($tweets[$i]["text"], strval(😖))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //worried face
        if(strpos($tweets[$i]["text"], strval(😟))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //frowning face with open mouth
        if(strpos($tweets[$i]["text"], strval(😦))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //confused face
        if(strpos($tweets[$i]["text"], strval(😕))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //expressionless face
        if(strpos($tweets[$i]["text"], strval(😑))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //japanese goblin
        if(strpos($tweets[$i]["text"], strval(👺))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //thumbs down
        if(strpos($tweets[$i]["text"], strval(👎))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //broken heart
        if(strpos($tweets[$i]["text"], strval(💔))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //crying cat face
        if(strpos($tweets[$i]["text"], strval(😿))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        

        //person frowning
        if(strpos($tweets[$i]["text"], strval(🙍))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }             

        //pouting cat face
        if(strpos($tweets[$i]["text"], strval(😾))!== false) {
            $tweets[$i]["algo_score"]--;
            $tweets[$i]["has_algo_score"] = 1;
        }        
    }
}
?>