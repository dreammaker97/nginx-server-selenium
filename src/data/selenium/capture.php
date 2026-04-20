<?php
require 'common.php';

$driverUrl = 'http://selenium:4444';
$url = $_GET['url'] ?? null;
$wait = (int)($_GET['wait'] ?? 3);
// $full = isset($_GET['full']);
$full = 1;
$token = $_GET['token'] ?? '';

if ($token !== 'sk-password') {
    http_response_code(403);
    exit('Forbidden');
}

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
                    '--disable-dev-shm-usage',
                    '--window-size=1366,1000'
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

// full page
if($full){
    [$_,$res,$_]=req("$driverUrl/session/$sessionId/execute/sync","POST",[
        "script"=>"return document.body.scrollHeight;",
        "args"=>[]
    ]);
    $height=json_decode($res,true)['value'] ?? 2000;

    req("$driverUrl/session/$sessionId/window/rect","POST",[
        "width"=>1366,
        "height"=>$height
    ]);
    sleep(1);
}

// screenshot
[$_,$shotRaw,$_]=req("$driverUrl/session/$sessionId/screenshot");
req("$driverUrl/session/$sessionId","DELETE");

$shot=json_decode($shotRaw,true);
if(!empty($shot['value'])){
    header("Content-Type: image/png");
    echo base64_decode($shot['value']);
    exit;
}

echo "Screenshot failed";
?>