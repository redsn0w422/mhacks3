<?php

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, json_encode($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "test_6a05f2e77654d976a6909be535a6fe4ee71:");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    return curl_exec($curl);
}

$send = array();
$send['name'] = 'Test Job Number One';
$send['to'] = 'adr_7fc7859e59649adc';
$send['from'] = 'adr_eac8493309facf3b';
$send['object1'] = 'obj_be9c671ac1a8ff49';

print_r($send);

print_r(CallAPI("POST", "https://api.lob.com/v1/jobs", $send));
?>