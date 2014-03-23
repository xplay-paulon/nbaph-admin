   <?php /*
   <div id="header">
      <a href="ads.php">Ads</a> |
      <a href="around.php">Around the NBA</a> |
      <a href="bloggers.php">Bloggers</a> |
      <a href="carousel.php">Carousel</a> |
      <a href="events.php">Events</a> |    
      <a href="features.php">Features</a> |
      <a href="headlines.php">Headlines</a> |
      <a href="action.php">NBA Action</a> |
      <a href="personalities.php">Personalities</a> |
      <a href="gallery.php">Photo Gallery</a> |
      <a href="polls.php">Polls</a> |
      <a href="starting.php">Starting 5</a> |
      <a href="videos.php">Videos</a>
   </div>
   */ ?>
   <script>
   sfHover = function() {
		var sfEls = document.getElementById("navbar").getElementsByTagName("li");
		for (var i=0; i<sfEls.length; i++) {
			sfEls[i].onmouseover=function() {
				this.className+=" hover";
			}
			sfEls[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp(" hover\\b"), "");
			}
		}
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);
   </script>
	<div id="header">
		<ul id="navbar">
			<li><a href="#">Ads</a><div><ul>
				<li><a href="ads.php">Main ads</a></li>
                <li><a href="bg_ads.php">Background ads</a></li>
				<li><a href="ad_block.php">Ad block</a></li>
				<li><a href="preroll.php">Preroll Ads</a></li>
				<li><a href="wall.php">Wall Ads</a></li>
				</div>
         </li>
			<li><a href="around.php">Around the NBA</a></li>
			<li><a href="#">Bloggers</a><div><ul>
				<li><a href="bloggers.php">Entries</a></li>
				<li><a href="bloggers_pic.php">Pictures</a></li>
				<li><a href="bloggers_order.php">Order</a></li></div></li>
			<li><a href="carousel.php">Carousel</a></li>
			<li><a href="#">Dance Team</a><div><ul>
				<li><a href="dance_featured.php">Featured</a></li>
				<li><a href="dance_photos.php">Photos</a></li>
				<li><a href="dance_video.php">Videos</a></li>
				<li><a href="dance_blog.php">Blog</a></li></ul></div>
			</li>
			<li><a href="#">Events</a><div><ul>
				<li><a href="events_calendar.php">Calendar</a></li>
				<li><a href="events_photos.php">Photos</a></li>
				<li><a href="events_video.php">Videos</a></li>
				<li><a href="events_blog.php">Blog</a></li></ul></div>
			</li>
			<li><a href="features.php">Features</a></li>
			<li><a href="headlines.php">Headlines</a></li>
			<li><a href="action.php">NBA Action</a></li>
			<li><a href="#">Personalities</a><div><ul>
				<li><a href="personalities.php">Entries</a></li>
				<li><a href="personalities_pic.php">Pictures</a></li>
				<li><a href="personalities_order.php">Order</a></li></div></li>
			<li><a href="gallery.php">Photo Gallery</a></li>
			<li><a href="polls.php">Polls</a></li>
			<li><a href="pinoy_beat.php">Beat Writer</a></li>
			<li><a href="offcourt.php">Off-Court News</a></li>
			<li><a href="starting.php">Starting 5</a></li>
			<li><a href="videos.php">Videos</a>
				<div><ul>
					<li><a href="videos.php">All</a></li>
					<li><a href="video-highlights.php">Highlights</a></li>
					<li><a href="video-top-plays.php">Top Plays</a></li>
					<li><a href="video-editors-pick.php">Editors Pick</a></li>
					<li><a href="video-nba-tv.php">NBA TV</a></li>
				</ul></div>	
			</li>
            <li><a href="main_bg.php">Background</a></li>			
			<li><a href="cron-capsules.php">Capsules</a></li>			
			<li><a href="around-the-nba.php">Around The NBA</a></li>
			<li><a href="cache.php">Clear Cache</a></li>
			<li class='last'><a href='global-games.php'>Global Games</a></li>
			<!--li class="last"><a href="#">Writers</a><div><ul>
				<li><a href="writers.php">Writer</a></li>				
				<li><a href="writers_story.php">Stories</a></li></div></li-->

		</ul>
		<div style="clear: both;"></div>
	</div>