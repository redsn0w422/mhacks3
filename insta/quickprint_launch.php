<!DOCTYPE html>
<html lang="en">
	<head>
	</head>
	<body>
		<?php
			$images = $_POST["checklist"];
//			print_r($images);
//			echo "<br/>";

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
			);
//			print_r($data);
//			echo "<br/>";

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

//			print_r($data_str);

			$result = curl_exec($ch);
			if ($result != false)
			{
				print_r($result);
			}
			else
			{
				echo "Bleh";
			}

			curl_close($ch);
		?>
	</body>
</html>
