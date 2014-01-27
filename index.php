<?php
require_once "bootstrap.php";
use Lob\Lob;

if ($handle = opendir('/server/php/files')) {
	while (false !== ($file = readdir($handle))) {
    	if (filectime($file)< (time()-10)) {  // 86400 = 60*60*24
        	unlink($file);
        }
	}
}


// pic print v2


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

// Login or logout url will be needed depending on current user state.
if ($user) {
	$logoutUrl = $facebook->getLogoutUrl(array('next'=>'http://yashamostofi.com/drinkspls/logout.php'));
} else {
	$fb_loginUrl = $facebook->getLoginUrl(array('scope' => 'user_photos'));
}

$styleSuffix = rand(1,1000);

?>

<html>
<head>
	<title>pic print</title>
	<link rel='stylesheet' href="css/bootstrap.min.css" >
	<link rel='stylesheet' type='text/css' href='picstylesheet.css?id=<?php echo rand(1,1000); ?>'/>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />        

	<!-- Generic page styles -->
	<link rel="stylesheet" href="css/style.css">
	<!-- blueimp Gallery styles -->
	<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="css/jquery.fileupload.css">
	<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
	<!-- CSS adjustments for browsers with JavaScript disabled -->
	<noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
	<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    	<!--[if lt IE 9]>
     	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      	<![endif]-->

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
      	<div id="container">
      		<div id="header">
      			<a href="#">pic print</a>
      		</div>



      		<div id="content">

      			<? if ($user): ?>
      			<a href='<?=$logoutUrl ?>'>
      				<img src="img/fb-out.png" alt="Disconnect Facebook">
      			</a>
      		<? endif; ?>
      		<? if (!($user)): ?>
      		<a href='<?=$fb_loginUrl ?>'>
      			<img src="img/fb-in.png" alt="Connect with Facebook">
      		</a>
      	<? endif; ?>

      </br>

      <? if ($insta_active): ?>
      <a href="./picprint.php">
      	<img src="img/insta-out.png" alt="Disconnect Instagram">
      </a>
  <? endif; ?>
  <? if (!($insta_active)): ?>
  <a href='<?=$insta_loginUrl ?>'>
  	<img src="img/insta-in.png" alt="Connect with Instagram">
  </a>
<? endif; ?>      

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
		<img src="img/mhacks.png" height="50" width="50" /></a>
		<p><a href="mailto:yasha.mostofi@gmail.com">Yasha Mostofi, </a>
			<a href="mailto:briantruong777@gmail.com">Brian Truong, </a>
			<a href="mailto:sonofthebrownguy@gmail.com">Kian Fotovat</a></p>
		</div>
	</div><br>
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Add files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar 
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
	-->
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    <br>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jquery.fileupload-validate.js"></script>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'server/php/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: false //i changed this from true!!!!!!
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index, file) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
</body> 
</html>
