# Sentiment Analysis

This is a tool that determines the sentiment of tweets in the way of a score, and ultimately ascertains whether the message is positive, neutral, or negative.  It works in three main steps:

1. Generate file of tweets
2. Strip unnecessary information from these tweets
3. Semantically analyze the sanitized tweets using several methods, such as dictionary lookup

Thanks to [this project](https://github.com/J7mbo/twitter-api-php) for making it simple to interface with Twitter's API.