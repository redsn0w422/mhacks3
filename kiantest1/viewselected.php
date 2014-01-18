<?php 
require 'facebook.php';
$checklist = $_POST['check_list'];
for($num=0; $num<count($checklist); $num++)
{
	echo '<img src ="https://i.embed.ly/1/display?url=' . $checklist[$num] . '&key=f4a9399a56fe4b6eb8ec6cd74c065b0f"/>';
	echo "<input type='checkbox' name='check_list[]' value='" . $checklist[$num] . "'/>";
	echo '</br>';
}
echo '<input type="submit" value="Print All"/>';
echo '<input type="submit" value="Print Selected"/>';
echo '<form action="index.php">';
echo '<input type="submit" value="Go Back"/>';
?>