<?php
// ********** INSTAGRAM ******************
require 'instagram.class.php';
$instagram = new Instagram(array('apiKey'=>'359a0cb55e014c2a853b77fed4769564',
'apiSecret'=>'a03c4453898846abbdadca739b4c1dde',
//'apiCallback'=>'localhost:5/mhacks/instacallback.php'));
'apiCallback' => 'http://yashamostofi.com/drinkspls/swag/instacallback.php'));
// create login URL
$insta_loginUrl = $instagram->getLoginUrl();

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
$logoutUrl = $facebook->getLogoutUrl(array('next'=>'http://yashamostofi.com/drinkspls/swag/logout.php'));
} else {
$fb_loginUrl = $facebook->getLoginUrl(array('scope' => 'user_photos'));
}

$styleSuffix = rand(1,1000);

?>

<html>
    <head>
        <title>pic print</title>
        <link rel='stylesheet' type='text/css' href='picstylesheet.css?id=<?php echo rand(1,1000); ?>'/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    </head>
    <body>

        <div id="container">
            <div id="header">
                pic print
            </div>

            <div id="content">
                <h2>pick your social network</h2>
                <a href='<?=$fb_loginUrl ?>'>
                    <img src="facebook-connect-logo.png" alt="Connect with Facebook">
                </a>
                </br>
                <a href='<?=$insta_loginUrl ?>'>
                    <img src="instagram-connect-logo.png" alt="Connect with Instagram">
                </a>
                </br>
                </br>
            </div>
            <? if ($user): ?>
            	<a href='<?=$logoutUrl ?>'>logout of facebook</a>
            
				<form action="viewselected.php" method="post">
			
				<? foreach ($links as $link): ?>
					<img src ="https://i.embed.ly/1/display?url=<?= $link ?>&key=f4a9399a56fe4b6eb8ec6cd74c065b0f"/>
						<input type='checkbox' name='check_list[]' value=<?= $link ?>/>
						</br>
				<? endforeach ?>
				<input type="submit" value="Choose Selected"/>
			<? endif; ?>
			
            <div id="footer">
                <a href="http://www.mhacks.org/">
                    <img src="mhacks.png" height="50" width="50" /></a>
                <p>&copy; gg</p>
            </div>
        </div>

	</body>
</html>