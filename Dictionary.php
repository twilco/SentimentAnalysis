<?php
/**
 * This class contains functions to read a sentiment dictionary from a file.  
 */
class Dictionary
{
    /**
     * Reads dictionary file into an array.  Note that this function returns an associative array that
     * has a "word" field and an "is_positive" field.  This means that your dictionary should probably
     * list a score of 0 for negative words/phrases and a score of 1 for positive words/phrases.
     * @param  String $file_path        Location of the dictionary file on the server.
     * @param  String $inline_delimiter Delimiter that separates a token from another in an entry.  For example, in "A LIE 0", the " " is the $inline_delimiter
     * @param  String $entry_delimiter  Delimiter that separates one dictionary entry from another.
     * @return StringArray              Array representation of the dictionary, containing "word" and "is_positive" fields.
     */
    public function read_dictionary($file_path, $inline_delimiter, $entry_delimiter)
    {
        $dictionary_array = explode($entry_delimiter, file_get_contents($file_path));

        for($i = 0; $i < count($dictionary_array); $i++) {
            $current_entry = explode($inline_delimiter, $dictionary_array[$i]);
            //we only have a single word and a score - AXED 0
            if(count($current_entry) == 2) {
                $dictionary[$i]["word"] = trim($current_entry[0]);
                $dictionary[$i]["is_positive"] = trim($current_entry[1]);
            } else {
                //current spot has multiple space delimited tokens - A LIE 0
                $build_word = "";
                for($j = 0; $j < count($current_entry); $j++) {
                    if(is_numeric(trim($current_entry[$j]))) {
                        //we have reached the score
                        $dictionary[$i]["word"] = trim($build_word);
                        $dictionary[$i]["is_positive"] = trim($current_entry[$j]);
                    } else {
                        $build_word .= " " . $current_entry[$j];
                    }
                }
            }
        }
        return $dictionary;
    }

    /**
     * Reads dictionary file into an array.  Note that this function returns an associative array that
     * has a "word" field and an "is_positive" field.  This means that your dictionary should probably
     * list a score of 0 for negative words/phrases and a score of 1 for positive words/phrases.
     *
     * This function was tailored specifically for the LSD dictionary, which requires three delimiters
     * to parse properly due to the use of * characters in tons of entries (AX* 0, BOTHER* 0, etc).  Other
     * dictionaries (I assume) would omit the use of the *, thus they would be able to utilize the regular
     * read_dictionary() function.
     * @param  String $file_path        Location of the dictionary file on the server.
     * @param  String $inline_delimiter Delimiter that separates a token from another in an entry.  For example, in "A LIE 0", the " " is the $inline_delimiter
     * @param  String $entry_delimiter  Delimiter that separates one dictionary entry from another.
     * @param  String $other_delimiter  Optional delimiter that can further delimit entries.  In "BLINDING* 0", the * is the $other_delimiter
     * @return StringArray              Array representation of the dictionary, containing "word" and "is_positive" fields.
     */
    public function read_LSD_dictionary($file_path, $inline_delimiter, $entry_delimiter, $other_delimiter)
    {
        $dictionary_array = explode($entry_delimiter, file_get_contents($file_path));

        for($i = 0; $i < count($dictionary_array); $i++) {
            if(strpos($dictionary_array[$i], $other_delimiter) !== false) {
                $current_entry = explode($other_delimiter, $dictionary_array[$i]);
                $dictionary[$i]["word"] = trim($current_entry[0]);
                $dictionary[$i]["is_positive"] = trim($current_entry[1]);
            } else {
                $current_entry = explode($inline_delimiter, $dictionary_array[$i]);
                //we only have a single word and a score - AXED 0
                if(count($current_entry) == 2) {
                    $dictionary[$i]["word"] = trim($current_entry[0]);
                    $dictionary[$i]["is_positive"] = trim($current_entry[1]);
                } else {
                    //current spot has multiple space delimited tokens - A LIE 0
                    $build_word = "";
                    for($j = 0; $j < count($current_entry); $j++) {
                        if(is_numeric(trim($current_entry[$j]))) {
                            //we have reached the score
                            $dictionary[$i]["word"] = trim($build_word);
                            $dictionary[$i]["is_positive"] = trim($current_entry[$j]);
                        } else {
                            $build_word .= " " . $current_entry[$j];
                        }
                    }
                }
            }
        }
        return $dictionary;
    }
}
?>