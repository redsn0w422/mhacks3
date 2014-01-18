<?php
	require 'facebook.php';
	include 'picprint.php';
<? if ($user): ?>
            
				<form action="viewselected.php" method="post">
			
				<? foreach ($links as $link): ?>
					<img src ="https://i.embed.ly/1/display?url=<?= $link ?>&key=f4a9399a56fe4b6eb8ec6cd74c065b0f"/>
						<input type='checkbox' name='check_list[]' value=<?= $link ?>/>
						</br>
				<? endforeach ?>
				<input type="submit" value="Choose Selected"/>
			<? endif; ?>
?>