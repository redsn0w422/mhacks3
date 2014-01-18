<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require 'facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '1414991652077072',
  'secret' => 'd7f434a8b143b848819e782d7d184645',
));

// Get User ID
Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
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
	echo '<form action="viewselected.php" method="post">';
	foreach($links as $link)
	{
		echo '<img src ="https://i.embed.ly/1/display?url=' . $link . '&key=f4a9399a56fe4b6eb8ec6cd74c065b0f"/>';
		echo "<input type='checkbox' name='check_list[]' value='" . $link . "'/>";
		echo '</br>';
	}
	echo '<input type="submit" value="Choose Selected"/>';
	if(!empty($_POST['check_list']))
	{
		foreach($_POST['check_list'] as $check)
		{
            echo $check;
		}
	}
  } 
  catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl(array('next'=>'http://yashamostofi.com/drinkspls/phpround2/logout.php'));
} else {
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'user_photos'));
}
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>Choose Photos to Print</title>
  </head>
  <body>
    <?php if ($user): ?>
      </br>
	  <a href='<?php $logoutUrl ?>'>Logout</a>s
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>
	
  </body>
</html>
