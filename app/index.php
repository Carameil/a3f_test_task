<?php

include_once __DIR__ . '/vendor/autoload.php';

use App\Parser;


header('Content-Type:application/json');
$url = "https://getbootstrap.com/docs/5.2/examples/checkout/";

$parser = new Parser($url);
$parser->loadDoc();
$result = $parser->calcTags();

echo json_encode($result);
