<?php

function guzzle($config = []) {

	return new \GuzzleHttp\Client($config);

}

function cache() {

	return new \Predis\Client(['database' => 15]);

}