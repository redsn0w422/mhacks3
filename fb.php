<?php
	require 'facebook.php';
	include 'picprint.php';
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
?>