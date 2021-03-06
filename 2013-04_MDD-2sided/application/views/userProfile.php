<? 
	$this->load->helper('isMulti.php');

	if(!isMulti($profileInfo)){
		// No
	}else{
		//$userInfo = $profileInfo[0];
	}

	// echo '<pre>';
	// print_r($profileInfo);
	// echo '</pre>';

	$userInfo = $profileInfo['userInfo'];


	$button = array('class' => 'button');
?>

	<div id="info">
		<div class="sizer">
			<section id="picture">
				<? if($userInfo['profile_img']){
					echo img('imgs/profile_imgs/'.$userInfo['profile_img']); 
				}else{
					echo img('imgs/profile_imgs/profile-img_placeholder.png'); 
				} 

				if(isset($uploadImage)){ ?>
					
					<? echo form_open_multipart("upload/do_upload"); ?>

						<label class="filebutton">
		                	Change Image
		                	<span><input id="uploadButton"type="file" name="userfile" size="20" /></span>
		            	</label>
		            	<label class="filebutton" style="display: none;">
		               		Upload Image
		               		<span><input id="uploadSubmit" type="submit" value="upload" /></span>
		            	</label>
		            	
					<? echo form_close(); 
				}?>


				
				<div class="button"><? echo anchor("decks/userDecks/{$userInfo['user_id']}", 'View Decks', 'View Decks');?></div>
				
				<ul class="profileLinks">
					<li><? echo anchor("user/friendList/{$userInfo['user_id']}", 'Friends', 'View all of friends'); ?></li>
					<li><? echo anchor("user/badgeList/{$userInfo['user_id']}", 'Badges', 'View all badges'); ?></li>
					<li class="last"><? echo anchor("user/tagList/{$userInfo['user_id']}", 'Tags', 'View all tags'); ?></li>
				</ul>
			</section>
			
			<section id="profileInfo">
				<h1><? echo $userInfo['username'] ?></h1>
				<h2><? echo $userInfo['date_of_reg']; ?></h2>

				<? if($profileInfo['profileViews'] == 0){
					// Noone has viewed this profile yet, do not include profile count
				}else{ ?>
					<h2><? echo $profileInfo['profileViews']; ?> Profile Views</h2>
				<? } ?>

				<h3 class="rating"><? echo $profileInfo['ratingCount'] ?></h3>
			</section>

			<section id="quickInfo">
				<ul>
					<li><h1><? echo $profileInfo['friendCount']; ?></h1><h2>Friends</h2></li>
					<li><h1><? echo $profileInfo['deckCount']; ?></h1><h2>Decks</h2></li>
					<li><h1><? echo $profileInfo['cardCount']; ?></h1><h2>Cards</h2></li>
					<li><h1><? echo $profileInfo['badgeCount']; ?></h1><h2>Badges</h2></li>
					<li class="last"><h1><? echo $profileInfo['tagCount']; ?></h1><h2>Tags</h2></li>
				</ul>
			</section>

			<section id="bgroup">

				<? 
					if(isset($friendRequests)){
						
						if($this->session->userdata('isLoggedIn') == 1 && $userInfo['user_id'] && $friendRequests == true){ ?>
							
							<!-- user has friend requests to check -->	
							<div class="button"><? echo anchor("notifications/checkNewNotifications", 'Notifications ('.count($friendRequests).')' , "Check your notifications") ?></div>
					
						<? }else{
							echo $friendRequests;
						}

					}if(isset($areFriends)){

						$loggedInUser = $this->session->userdata('userID');

						if(!$areFriends){ ?>

							<!-- users are not friends and can add each other -->
							<div class="button"><? echo anchor("friends/addNewFriend/{$loggedInUser}/{$userInfo["user_id"]}", 'Add Friend' , "Add new friend") ?></div>
						
						<? }if($loggedInUser == $areFriends[0]['user_id'] && $areFriends[0]['active'] == 0){ ?>

							<!-- logged in user has already sent a friend request and is waiting to be accepted -->
							<button class="voted">Pending Request</button>	
						
						<? } else{ 
							// echo "userProfile/areFriends/else";
						}
					}
				?>

			</section>

		</div>	<!-- end of sizer -->
	</div> <!-- end of info -->

	<div id="activity">
		<div class="dbbg"><div class="sizer"><h1>Activity</h1></div></div>
		<div class="sizer">
			<ul>
				<li><? echo img('imgs/badgeExample.png'); ?><p>New Badge! <? echo $userInfo['username']; ?> received a new badge! </p><p class="date"><? echo date('M d, Y'); ?></p></li>
				<li><? echo img('imgs/badgeExample.png'); ?><p>New Badge! <? echo $userInfo['username']; ?> received a new badge! </p><p class="date"><? echo date('M d, Y'); ?></p></li>
				<li><? echo img('imgs/badgeExample.png'); ?><p>New Badge! <? echo $userInfo['username']; ?> received a new badge! </p><p class="date"><? echo date('M d, Y'); ?></p></li>
				<li><? echo img('imgs/badgeExample.png'); ?><p>New Badge! <? echo $userInfo['username']; ?> received a new badge! </p><p class="date"><? echo date('M d, Y'); ?></p></li>
				<li><? echo img('imgs/badgeExample.png'); ?><p>New Badge! <? echo $userInfo['username']; ?> received a new badge! </p><p class="date"><? echo date('M d, Y'); ?></p></li>
			</ul>
		</div>
	</div>

	<!-- Jquery -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<? echo base_url(); ?>js/libs/jquery-1.9.1.min.js"><\/script>')</script>

	<!-- Scripts -->
	<script type="text/javascript" src="<? echo base_url(); ?>js/main.js"></script>

	<!-- Inits -->
	<script>initUpload();</script>
