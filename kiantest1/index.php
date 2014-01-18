<?php
require_once 'facebook.php';
$config = array(
    'appId' => '1414991652077072',
    'secret' => 'd7f434a8b143b848819e782d7d184645',
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
  );
$facebook = new Facebook($config);
$user_id = $facebook->getUser();
$login_url = $facebook->getLoginUrl();
?>
<html>
<head></head>
<body>
<?php
	if($user_id)
	{
	  // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try
	  {
        $user_profile = $facebook->api('/me','GET');
        echo "Name: " . $user_profile['name'];
      }
	  catch(FacebookApiException $e)
	  {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    }
	else
	{
		$login_url = $facebook->getLoginUrl();
		//$login_url = "https://www.facebook.com/dialog/oauth?client_id=1414991652077072&redirect_uri=http%3A%2F%2Fyashamostofi.com%2Fdrinkspls%2Ffbtest%2F&state=e804a37689cb944ec6761558e954bab8&sdk=php-sdk-3.2.3";
		echo 'Please <a href="' . $login_url . '">login.</a>';
	}
?>
</body>
</html>