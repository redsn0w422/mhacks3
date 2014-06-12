<?php
require_once "bootstrap.php";
use Lob\Lob;

// ********** INSTAGRAM ******************
require 'instagram.class.php';
$instagram = new Instagram(array('apiKey'=>'359a0cb55e014c2a853b77fed4769564',
'apiSecret'=>'a03c4453898846abbdadca739b4c1dde',
//'apiCallback'=>'localhost:5/mhacks/instacallback.php'));
'apiCallback' => 'http://yashamostofi.com/drinkspls/picprint.php'));
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

// Login or logout url will be needed depending on current user state. --NO LONGER NEEDED
//if ($user) {
//$logoutUrl = $facebook->getLogoutUrl(array('next'=>'http://yashamostofi.com/drinkspls/logout.php'));
//} else {
//$fb_loginUrl = $facebook->getLoginUrl(array('scope' => 'user_photos'));
///}
//
//$styleSuffix = rand(1,1000);
//
//?>

<html>
    <head>
        <title>pic print</title>
        <!--<script>
      		window.fbAsyncInit = function() {
        		FB.init({
          			appId      : '1414991652077072',
          			xfbml      : true,
          			version    : 'v2.0'
        		});
      		};
		(function(d, s, id){
         		var js, fjs = d.getElementsByTagName(s)[0];
         		if (d.getElementById(id)) {return;}
         		js = d.createElement(s); js.id = id;
         		js.src = "//connect.facebook.net/en_US/sdk.js";
         		fjs.parentNode.insertBefore(js, fjs);
       			}(document, 'script', 'facebook-jssdk'));
    	</script> -->
        <link rel='stylesheet' type='text/css' href='picstylesheet.css?id=<?php echo rand(1,1000); ?>'/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width" />        
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>		
		<script>
			$('document').ready(function(){
				$('#lob_extra_data').hide('fast');
			});
			
			function checkRadio(){					
				if ($('input[name=sendAPI]:checked').val() == "lob")
				{
					$('#lob_extra_data').show('fast');
				}
				else
				{
					$('#lob_extra_data').hide('fast');
				}
			}
		</script>
	</head>
    <body>
    <script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '1414991652077072',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.0' // use version 2.0
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
location.reload(true);
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->
<div class="fb-login-button" data-auto-logout-link="true" scope="public_profile,user_photos" onlogin="checkLoginState();"></div>
<div id="status">
</div>
       <!-- <div id="fb-root"></div>
		<script>(function(d, s, id) {
  			var js, fjs = d.getElementsByTagName(s)[0];
  			if (d.getElementById(id)) return;
  			js = d.createElement(s); js.id = id;
  			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1414991652077072&version=v2.0";
  			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
        <div id="container">
            <div id="header">
                pic print
            </div>

            <div id="content">
            	<div class="fb-login-button" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="true"></div>
            	? if ($user): ?>
            			<a href='?=$logoutUrl ?>'>
            			<img src="fb-out.png" alt="Disconnect Facebook">
            		</a>
            	? endif; ?>
            	? if (!($user)): ?>
            		<a href='?=$fb_loginUrl ?>'>
            			<img src="fb-in.png" alt="Connect with Facebook">
            		</a>
            	? endif; ?>
            	
            -->	</br>
            	
            	<? if ($insta_active): ?>
							<a href="./picprint.php">
            			<img src="insta-out.png" alt="Disconnect Instagram">
            		</a>
            	<? endif; ?>
            	<? if (!($insta_active)): ?>
            		<a href='<?=$insta_loginUrl ?>'>
            			<img src="insta-in.png" alt="Connect with Instagram">
            		</a>
            	<? endif; ?>          

            </div>
					</div>
            
				<form action="quickprint_launch.php" method="post">
			<? if ($user): ?>
				<div class="container">
					<h3>facebook</h3>
					<div class="main">
						<ul class="grid">
			
							<? foreach ($links as $link): ?>
								<li>
									<input type='checkbox' class='checkbox' name='checklist[]' value='<?= $link ?>'/>
									<img class="media" src ="https://i.embed.ly/1/display?url=<?= $link ?>&key=f4a9399a56fe4b6eb8ec6cd74c065b0f"/>
									<div class="content">
										<div class="comment"></div>
									</div>
								</li>
							<? endforeach ?>
						</ul>
					</div>
				</div>
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
									$content .= "<input type=\"checkbox\" class=\"checkbox\" name=\"checklist[]\" value=\"{$url}\">";
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
	
			<? if ($user or $insta_active): ?>
					<p class="radioLabel">
					<input type="radio" name="sendAPI" value="quick" onclick='checkRadio()' checked>
					QuickPrint with Walgreens
					<!--
					<input type="radio" name="sendAPI" value="lob" id="lobRadio" onclick='checkRadio()'>
					Mail with Lob</p>
					-->
				<div id="lob_extra_data">
					From... To...
					</br>
					<input type="text" size="25" name="fromName" placeholder="From..." />
					<input type="text" size="25" name="toName" placeholder="To..." />
					</br>
					<input type="text" size="25" name="fromAddress" placeholder="Address line 1..." />
					<input type="text" size="25" name="toAddress" placeholder="Address Line 1..." />
					</br>
					<input type="text" size="25" name="fromCity" placeholder="City..." />
					<input type="text" size="25" name="toCity" placeholder="City..." />
					</br>
					<input type="text" size="25" name="fromState" placeholder="State..." />
					<input type="text" size="25" name="toState" placeholder="State..." />
					</br>
					<input type="text" size="25" name="fromZipCode" placeholder="Zip Code..." />
					<input type="text" size="25" name="toZipCode" placeholder="Zip Code..."/>
				</div>
				<div class="submit_div">
					<input class="submit_button" type="submit" value="Submit" id="final_submit" />
				</div>
				
			<? endif; ?>
			</form>

			</br class="clearFloat">
			
            <div id="footer">
                <a href="http://www.mhacks.org/">
                    <img src="mhacks.png" height="50" width="50" /></a>
                <p><a href="mailto:yasha.mostofi@gmail.com">Yasha Mostofi, </a>
                	<a href="mailto:briantruong777@gmail.com">Brian Truong, </a>
                	<a href="mailto:sonofthebrownguy@gmail.com">Kian Fotovat</a></p>
            </div>

	</body>
</html>
