<?php

namespace App\Service;

use Abraham\TwitterOAuth\TwitterOAuth;

class ApiTwitter
{
    public function post(string $content): void
    {
        $consumerKey = $_ENV['TWITTER_CONSUMER_KEY'];
        $consumerSecret = $_ENV['TWITTER_CONSUMER_SECRET'];
        $accessToken = $_ENV['TWITTER_ACCESS_TOKEN'];
        $accessTokenSecret = $_ENV['TWITTER_ACCESS_TOKEN_SECRET'];
        $connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
        $connection->post("statuses/update", ["status" => $content]);
    }
}
