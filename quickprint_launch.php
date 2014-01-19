<?php
	$images = $_POST["checklist"];
	if (empty($images))
	{
		header('Location: http://yashamostofi.com/drinkspls/picprint.php');
		exit;
	}

	$data = array(
		'transaction' => 'photocheckoutv2',
		'apikey' => 'a61e8e47ca83e86a2b8c705899ae9f6d',
//				'apiKey' => '7c76c8de1d78fd30331368a9122b542b',
		'devinf' => 'Chrome,32.0.1700.76',
		'act' => 'mweb5UrlV2',
		'view' => 'mweb5UrlV2JSON',
		'affId' => 'hackathon',
//				'affId' => 'extest1',
		'appver' => '1.0',
		'images' => $images,
		'channelInfo' => 'web',
		'callBackLink' => 'http://yashamostofi.com/drinkspls/picprint.php',
	);

	$data_str = json_encode($data);

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://services-qa.walgreens.com/api/util/v2.0/mweb5url");
//			curl_setopt($ch, CURLOPT_URL, "https://services.walgreens.com/api/util/v2.0/mweb5url");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_str))
	);

	$result = curl_exec($ch);
	curl_close($ch);
	if ($result != false)
	{
		$result_json = json_decode($result);
		$url_str = $result_json->landingUrl . "&token=" . $result_json->token;

		header('Location: ' . $url_str);
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	</head>
	<body>
		Hello
	</body>
</html>
