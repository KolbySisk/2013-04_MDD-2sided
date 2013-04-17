<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<title>2sided - The Social Way to Study</title>

		<meta name="description" content="A social way to study using flashcards.">
		<meta name="author" content="Kristy Miller, Kolby Sisk">

		<!-- Favicon -->
		<?php echo link_tag("favicon.ico", "shortcut icon", "image/ico");?>
		  
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	
	<body>

		<header>
			<div class="sizer">
				<a href="<? echo base_url(); ?>"><img src="<? echo base_url(); ?>imgs/logo.png" alt="2sided Logo" width="66" height="43" /></a>
				<nav>
					<ul id="navigation">
						<li class="yourdecks"><? echo anchor('authentication', 'Your Decks', 'Your personal decks') ?></li>
						<li class="browse"><? echo anchor('browse', 'Browse', 'Browse all decks') ?></li>
						<li class="about"><? echo anchor('browse/about', 'About', 'About 2sided') ?></li>
						<li class="tags"><? echo anchor('browse/tags', 'Tags', 'Search by tags') ?></li>
						<li class="users"><? echo anchor('browse/users', 'Users', 'Search by users') ?></li>
					</ul>

					<input type="text" placeholder="search" id="searchIni"/>

					<ul id="searchResults"></ul>
					
					<ul id="tools">
						<li><? echo anchor('authentication', "Log In", 'title="User Login"'); ?></li>
						<li><? echo anchor('authentication', "Sign Up", 'title="New User Registration"'); ?></li>
					</ul>
				</nav>
			</div>
		</header>