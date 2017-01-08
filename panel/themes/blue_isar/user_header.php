
 <div  style="margin-bottom:0px">
      <div class="navbar-inner pinkMenu">
        <div class="row">   
			
			<div class="span4 navbar-form pull-right" style="width:30%">
				
				<a href="<?php echo $info['user_url']; ?>" class="pull-right"> 
					<div id="siteLogo" style="float:right"></div>
					<div style="margin-top:5px;float: left; padding: 3px;font-weight: bold;font-size: 14pt;">
					پنل کاربری
					</div>
				</a>
            </div> 
			
			<div class="span4  pull-right">
				<form class="navbar-form   pull-left"   method="get" action="<?php echo $info['user_url']; ?>telgroups/search_result">
				  <input type="text" placeholder="جستجو …" value="" name="s" title="جستجو برای:" class="span2" style="height: inherit;">
				  <button onclick="this.submit()" class="btn" value=""><span class="icon-search" aria-hidden="true" value=""></span></button>
				</form>
			</div>
			<div  class="span3 pull-left" style="height:40px;float:left " >
				<div class="menu-image">
					<div style="margin-top: 10px;float: right;color: #222;">
					  <?php echo $info['username'] ?>
					  </div>
					<div class="menu_arrow"></div>
					<div class="menu_img">
						<img src="<?php echo $info['url']; ?>panel/views/images/logo.png" title="admin2">
						
					</div>
				</div>
		
				<div id="menu-dd-container" class="menu-dd-container" style="font-family:BKoodakBold">
					<div class="menu-dd-content">
						<div class="menu-divider "></div>
						
						<div class="menu-divider "></div>
						<a href="<?php echo $info['user_url'] ?>" rel="loadpage">
							<div class="menu-dd-row">ناحیه کاربری</div>
						</a>
						
						<div class="menu-divider "></div>
						<a href="<?php echo $info['logout_url'] ?>">
							<div class="menu-dd-row">خروج</div>
						</a>
					</div>
				</div>
	
			
				
<script type="text/javascript">

	function dropdownMenu(type) {
		// 1: Reset the menu
		if(type) {
			$('.menu-image').removeClass('menu-image-active');
			$('#menu-dd-container').hide();
		} else {
			// Dropdown Menu Icon
			$('.menu-image').on("click", function() {
				$('.menu-image').toggleClass('menu-image-active');
				$('#menu-dd-container').toggle();
			});
			
			$(document).on("click", function(){
				// Hide the image drop-down menu
				dropdownMenu(1);
				
				// Hide the search results
				manageResults(0);
			});

			$(".menu-image, .search-results").on("click", function(e) {
				e.stopPropagation();
			});
		}
	}
	function manageResults(x) {
		if(x == 0) {
			$(".search-container").hide();
			$(".search-content").remove();
		} else if(x == 1) {
			var q = $("#search").val();
			liveLoad('index.php?a=search&q='+q.replace(' ','+'));
		} else if(x == 2) {
			var q = $("#search").val();
			liveLoad('index.php?a=explore&filter='+q.replace('#',''));
		}
	}
	$(document).ready(function() {
		// Start loading
		dropdownMenu();
	});
</script>
        </div>
		</div>
      </div>
</div> 
<div class="pull-center">


</div>

