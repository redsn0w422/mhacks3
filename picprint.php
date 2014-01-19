<?php
// ********** INSTAGRAM ******************
require 'instagram.class.php';
$instagram = new Instagram(array('apiKey'=>'359a0cb55e014c2a853b77fed4769564',
'apiSecret'=>'a03c4453898846abbdadca739b4c1dde',
//'apiCallback'=>'localhost:5/mhacks/instacallback.php'));
'apiCallback' => 'http://yashamostofi.com/drinkspls/swag/picprint.php'));
// create login URL
$insta_loginUrl = $instagram->getLoginUrl();

// receive OAuth code parameter
$code = $_GET['code'];

$insta_active = false;

// check whether the user has granted access
if (isset($code)) {
	$insta_active = true;

	try {
		// receive OAuth token object
		$data = $instagram->getOAuthToken($code);
		$username = $username = $data->user->username;
		
		// store user access token
		$instagram->setAccessToken($data);

		// now you have access to all authenticated user methods
		$result = $instagram->getUserMedia();
	}
	catch (Exception $e) {
//		echo "Caught exception: '{$e->getMessage()}'\n{$e}\n";
		$insta_active = false;
	}
} else {
	$insta_active = false;
	// check whether an error occurred
	if (isset($_GET['error'])) {
		echo 'An error occurred: ' . $_GET['error_description'];
	}
}

// ********** FACEBOOK ******************
require 'facebook.php';
$facebook = new Facebook(array(
'appId'  => '1414991652077072',
'secret' => 'd7f434a8b143b848819e782d7d184645',
));

Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
$user = $facebook->getUser();

if ($user) {
	try {
		$user_profile = $facebook->api($facebook->getUser() . '/photos/uploaded', array('access_token' => $facebook->getAccessToken()));
		$pics = $user_profile;
		$pics1 = $pics['data'];
		$links = array();
		$num = 0;
		foreach($pics1 as $p)
		{
			$links[$num] = $p['source'];
			$num = $num+1;
		}
		
	} 
	catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

// Login or logout url will be needed depending on current user state.
if ($user) {
$logoutUrl = $facebook->getLogoutUrl(array('next'=>'http://yashamostofi.com/drinkspls/swag/assets/api/logout.php'));
} else {
$fb_loginUrl = $facebook->getLoginUrl(array('scope' => 'user_photos'));
}

$styleSuffix = rand(1,1000);

?>

<html>
    <head>
        <title>pic print</title>
        <link rel='stylesheet' type='text/css' href='assets/css/picstylesheet.css?id=<?php echo rand(1,1000); ?>'/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div id="container">
            <div id="header">
                pic print
            </div>

            <div id="content">
            	
            	<? if ($user): ?>
            		<a href='<?=$ogoutUrl ?>'>
            			<img src="assets/img/fb-out.png" alt="Disconnect Facebook">
            		</a>
            	<? endif; ?>
            	<? if (!($user)): ?>
            		<a href='<?=$fb_loginUrl ?>'>
            			<img src="assets/img/fb-in.png" alt="Connect with Facebook">
            		</a>
            	<? endif; ?>
            	
            	</br>
            	
            	<? if ($insta_active): ?>
            		<a href="">
            			<img src="assets/img/insta-out.png" alt="Disconnect Instagram">
            		</a>
            	<? endif; ?>
            	<? if (!($insta_active)): ?>
            		<a href='<?=$insta_loginUrl ?>'>
            			<img src="assets/img/insta-in.png" alt="Connect with Instagram">
            		</a>
            	<? endif; ?>          

            </div>
            
				<form action="assets/api/quickprint_launch.php" method="post">
			<? if ($user): ?>
            	
				<? foreach ($links as $link): ?>
					<img src ="https://i.embed.ly/1/display?url=<?= $link ?>&key=f4a9399a56fe4b6eb8ec6cd74c065b0f"/>
						<input type='checkbox' name='checklist[]' value='162.243.204.101/api.php?url='<?= $link ?>'/>
						</br>
				<? endforeach ?>
			<? endif; ?>

			<? if ($insta_active): ?>
				<div class="container">
						<h1>Instagram photos taken by <?= $data->user->username ?></h1>
					<div class="main">
							<ul class="grid">
								<?php
								// display all user uploads
								foreach ($result->data as $media)
								{
									$content = "<li>";
									
									// output media
									$image = $media->images->low_resolution->url;
									$url = $media->images->standard_resolution->url;
									$content .= "<input type=\"checkbox\" class=\"checkbox\" name=\"checklist[]\" value=\"162.243.204.101/api.php?url={$url}\">";
									$content .= "<img class=\"media\" src=\"{$image}\"/>";
									
									// create meta section
									$comment = $media->caption->text;
									$content .= "<div class=\"content\">
																 <div class=\"comment\">{$comment}</div>
															 </div>";
									
									// output media
									echo $content . "</li>";
								}
								?>
							</ul>
					</div>
				</div>
			<? endif; ?>

			<? if ($user || $insta_active): ?>
				<div class="submit_div">
					<input class="submit_button" type="submit" name="action" value="quick">
					<input class="submit_button" type="submit" name="action" value="lob">
				</div>
			<? endif; ?>
			</form>
			
            <div id="footer">
                <a href="http://www.mhacks.org/">
                    <img src="mhacks.png" height="50" width="50" /></a>
                <p>&copy; gg</p>
            </div>
        </div>

	</body>
</html>
