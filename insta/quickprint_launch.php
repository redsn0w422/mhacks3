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
				'devinf' => 'Chrome,32.0.1700.76',
				'act' => 'mweb5UrlV2',
				'view' => 'mweb5UrlV2JSON',
				'affId' => 'extest1',
				'appver' => '1.0',
				'images' => $images,
			);
//			print_r($data);
//			echo "<br/>";

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, "https://services-qa.walgreens.com/api/util/v2.0/mweb5url");
//			curl_setopt($ch, CURLOPT_URL, "https://services.walgreens.com/api/util/v2.0/mweb5url");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//			print_r($ch);

			$result = curl_exec($ch);
			if ($result != null)
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
