<header>
	<div class="sizer">
		<div id="login"><? echo anchor("authentication/userLogin", "Log In", 'title="User Log In"'); ?></div>
		<div id="logo"><a href="<? echo base_url(); ?>"><img src="<? echo base_url(); ?>imgs/logo.png" alt="2sided Logo" width="66" height="43" /></a></div>
		<div id="research"></div>	
		<nav>
			<ul id="navigation">
				<li class="decks active"><? echo anchor('decks', 'Decks', 'Browse all decks') ?></li>
				<li class="users"><? echo anchor('user/viewAll', 'Users', 'Search by users') ?></li>
				<li class="tags"><? echo anchor('decks/tags', 'Tags', 'Search by tags') ?></li>
				<li class="signup"><? echo anchor('authentication', "Sign Up", 'title="New User Registration"'); ?></li>
			</ul>
		</nav>
	</div>
</header>