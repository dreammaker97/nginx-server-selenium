<?php
require 'common.php';

$driverUrl = 'http://selenium:4444';
$url = $_GET['url'] ?? null;
$wait = (int)($_GET['wait'] ?? 3);

if (!$url) {
    http_response_code(400);
    echo "Missing url";
    exit;
}

// create session
[$_, $res, $_] = req($driverUrl.'/session','POST',[
    'capabilities'=>[
        'alwaysMatch'=>[
            'browserName'=>'chrome',
            'platformName'=>'linux',
            'goog:chromeOptions'=>[
                'args'=>[
                    '--headless=new',
                    '--no-sandbox',
                    '--disable-dev-shm-usage'
                ]
            ]
        ]
    ]
]);

$sessionId = json_decode($res,true)['value']['sessionId'] ?? null;
if(!$sessionId){ exit("Cannot create session"); }

// open url
req("$driverUrl/session/$sessionId/url","POST",['url'=>$url]);
sleep($wait);

// get html
[$_,$htmlRaw,$_]=req("$driverUrl/session/$sessionId/source");

// close
req("$driverUrl/session/$sessionId","DELETE");

echo $htmlRaw;
?>