<?php
	require 'instagram.class.php';
	echo "<p>hi</p>";
	$instagram = new Instagram(array('apiKey'=>'359a0cb55e014c2a853b77fed4769564',
	'apiSecret'=>'a03c4453898846abbdadca739b4c1dde',
	//'apiCallback'=>'localhost:5/mhacks/instacallback.php'));
	'apiCallback' => 'http://yashamostofi.com/drinkspls/swag/instacallback.php'));
	  
	// create login URL
	$insta_loginUrl = $instagram->getLoginUrl();
	echo $insta_loginUrl;
	
	echo <<<_END
	
	<html>
	<head>
		<title>pic print</title>
		<link rel='stylesheet' type='text/css' href='picstylesheet.css?id=<?php echo rand(1,1000); ?>'/>
	</head>
	<body>
	
	<div id="container">
		<div id="header">
			pic print
		</div>
		
		<div id="content">
		<h2>pick your social network</h2>
		<a href="<? echo $fb_loginUrl ?>">
		<img src="facebook-connect-logo.png" alt="Connect with Facebook">
		</a>
		</br>
		<a href="$insta_loginUrl">
		<img src="instagram-connect-logo.png" alt="Connect with Instagram">
		</a>
		</br>
		</br>
		</div>
		
		<div id="footer">
		<a href="http://www.mhacks.org/">
		<img src="mhacks.png" height="50" width="50" /></a>
        <p>&copy; gg</p>
        </div>
    </div>
	</body>
</html>
_END;
?>