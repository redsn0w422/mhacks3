<?php

echo <<<_END

<html>
	<head>
		<title>Pic Print - Step 2</title> 
		
		<link rel='stylesheet' type='text/css' href='stylesheet.css'/>

	</head>
	
	</body>
	<div id="container">
		<h3>Pic Print Part 2</h3>

_END;

if (isset($_POST['username']))
    $username = $_POST['username'];
else
    $username = "";

if (isset($_POST['password']))
    $password = $_POST['password'];
else
    $password = "";

if (isset($_POST['SOCIAL_NETWORK']))
    $SOCIAL_NETWORK = $_POST['SOCIAL_NETWORK'];
else
    $SOCIAL_NETWORK = "";



// condition to check if user can move on or not,
// return to login page if user cannot.
if (($username == "") or ($password == "") or ($SOCIAL_NETWORK == "")) {
    $CONTINUE = false;
    // error occurred, something obviously didn't work correctly.
} else {
    $CONTINUE = true;
}

if (!($CONTINUE)) {
    // show the user the form again, allow them to attempt filling in 
    // ALL the information
    echo "Information is incomplete, please try again.";
	echo <<<_END

    	<form action="phpscript.php" method="POST" name="introForm" id="introForm">
    		Username:
    		<input type="text" id="username" name="username" placeholder="username..."/>
    		</br>
    		Password:
    		<input type="password" id="password" name="password" />
    		</br>
    		</br>
    		<input type="radio" name="SOCIAL_NETWORK" value="fb" />
    		Facebook
    		<input type="radio" name="SOCIAL_NETWORK" value="insta" />
    		Instragram
    		</br>
    		<input type="submit" value="Submit!" />
    	</form>
_END;

} else {
    echo $username . $password . $SOCIAL_NETWORK;
    // decide which social network API to use
    if ($SOCIAL_NETWORK == "fb") {
        // use facebook
    } else if ($SOCIAL_NETWORK == "insta") {
        // use instagram
    } else {
        // what is this I don't even
    }
}

echo <<<_END
	</body>
</html>
_END;
?>