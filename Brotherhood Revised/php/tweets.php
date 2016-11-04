<?php

require_once 'twitter-php/twitter.class.php';

//Twitter OAuth Settings, enter your settings here:
$CONSUMER_KEY = 'jWtBBD3r82IKvCIWT5wd3SPp0';
$CONSUMER_SECRET = 'A6teF5xrKttHQ08BGgqpuLswKebYgCHhKJ0wjz5hNYD5HdJf3k';
$ACCESS_TOKEN = '788766800204869633-04ZQOnT925gwj6xrx4BtwCZSuDiRPxn';
$ACCESS_TOKEN_SECRET = 'wyovCAdZCcpr4IXSet9PcpjfQA4grQJKR9SODlxtmm7za';

$twitter = new Twitter($CONSUMER_KEY, $CONSUMER_SECRET, $ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);

// retrieve data
$q = $_POST['q'];
$count = $_POST['count'];
$api = $_POST['api'];

// api data
$params = array(
    'screen_name' => $q,
    'q' => $q,
    'count' => 20,
    'includes_rts' => true
);

$results = $twitter->request($api, 'GET', $params);

// output as JSON
echo json_encode($results);
?>