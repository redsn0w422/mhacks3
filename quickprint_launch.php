<?php
require_once "bootstrap.php";
use Lob\Lob;

	$images = $_POST["checklist"];
	//if (empty($images))
	//{
	//	header('Location: http://yashamostofi.com/drinkspls/picprint.php');
	//	exit;
	//}
	
	
	if ($_POST['sendAPI'] == "quick")
	{

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
	}
	else
	{
		$apiKey = 'test_6a05f2e77654d976a6909be535a6fe4ee71';
		$lob = new Lob($apiKey);
		$lob->setVersion('v1'); // "v1" is the default value
		$date = new DateTime();
		
		var_dump(get_class($lob->settings()));
		echo "</br></br></br>";
		$settingList = $lob->settings()->retrieveList();
		var_dump($settingList);
		die();

		try {
    		// Returns a valid address
    		$toAddress = $lob->addresses()->create(array(
        	'name'              =>  $_POST['toName'], 
        	'address_line1'     =>  $_POST['toAddress'],
        	'address_city'      =>  $_POST['toCity'],
        	'address_state'     =>  $_POST['toState'],
        	'address_country'   => 'US', 
        	'address_zip'       =>  $_POST['toZipCode'],
    		));
    		echo "to address made successfully.";
			} catch (\Lob\Exception\ValidationException $e) {
    		var_dump($toAddress);
    		die();
		}
		
		
		try {
    		// Returns a valid address
    		$fromAddress = $lob->addresses()->create(array(
        	'name'              =>  $_POST['fromName'], 
        	'address_line1'     =>  $_POST['fromAddress'],
        	'address_city'      =>  $_POST['fromCity'],
        	'address_state'     =>  $_POST['fromState'],
        	'address_country'   => 'US', 
        	'address_zip'       =>  $_POST['fromZipCode'],
    		));
    		echo "from address made successfully.";
			} catch (\Lob\Exception\ValidationException $e) {
    		var_dump($fromAddress);
    		die();
		}
		
		// yo dawg we need PDFs
		$lobObjects = array();
		foreach ($images as $i=>$image)
		{	
			try {
    			// Returns a valid object
    			$lobObjects[$i] = $lob->objects()->create(array(
        			'name'        => $i,
        			'file'        => '162.243.204.101/api.php?url=' . $image,
        			'setting_id'  => 101, 
        			'quantity'    => 1,
   		 		));
   		 		echo "object made.";
   		 		echo $image;
				} catch (\Lob\Exception\ValidationException $e) {
					var_dump($lobObjects);
					echo $e;
    				die();
			}
		}
				
		$lobObjectIDS = array();
		foreach ($lobObjects as $i=>$object)
		{
        	        $lobOBjectIDS[$i] = $object['id'];
		}
		
		try {
    		// Returns a valid job
    		$job = $lob->jobs()->create(array(
        	'name'          => $date->getTimestamp(),
        	'to'            => $toAddress['id'], 
        	'from'          => $fromAddress['id'],
        	'object1'		=> $lobObjectIDS,
			));
			echo "job made.";
			} catch (\Lob\Exception\ValidationException $e) {
    		var_dump($job);
    		die();
		}
	}
