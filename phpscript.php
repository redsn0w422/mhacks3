<?php
echo "HI1";
echo <<<_END

<html>
	<head>
		<title>Pic Print - Step 2</title>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width" />        
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />

        <link rel='stylesheet' type='text/css' href='stylesheet.css'/>
	</head>
	</body>
	<div id="container>
		<h3>Pic Print Part 2</h3>

_END;
echo "HI2";
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

echo "HI3";
    
// condition to check if user can move on or not,
// return to login page if user cannot.
if (($username == "") or ($password == "") or ($SOCIAL_NETWORK == ""))
{
	$CONTINUE = false;
	// error occurred, something obviously didn't work correctly.
}	
else
{
	$CONTINUE = true;
}
echo "HI4";
if (!($CONTINUE))
{
	// show the user the form again, allow them to attempt filling in 
	// ALL the information
	echo "Information is incomplete, please try again.";
	
echo <<<_END

    	<form action="phpscript.php" method="POST" name="introForm" id="introForm">
    		<p>Username:</p>
    		<input type="text" id="username" name="username" placeholder="username..."/>
    		</br>
    		<p>Password:</p>
    		<input type="password" id="password" name="password" />
    		</br>
    		<input type="radio" name="SOCIAL_NETWORK" value="fb" />
    		<p>Facebook</p>
    		<input type="radio" name="SOCIAL_NETWORK" value="insta" />
    		<p>Instragram</p>
    		<input type="submit" value="Submit!" />
    	</form>
_END;
	
}
else
{
	echo $username . $password . $SOCIAL_NETWORK;
	// decide which social network API to use
	if ($SOCIAL_NETWORK == "fb")
	{
		// use facebook
	}
	else if ($SOCIAL_NETWORK == "insta")
	{
		// use instagram
	}
	else
	{
		// what is this I don't even
	}
}
echo "HI5";
echo <<<_END
	</body>
</html>
_END;
?>