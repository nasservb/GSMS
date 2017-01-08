
 <div  style="margin-bottom:0px">
      <div class="navbar-inner pinkMenu">
        <div class="row">
			<div class="span4 navbar-form pull-right">
				<a href="<?php echo ( $info['usertype']==1 ?  $info['admin_url'] : $info['employ_url']); ?>" class="pull-right"> <div id="siteLogo" ></div></a>
				<a href="<?php echo ( $info['usertype']==1 ?  $info['admin_url'] : $info['employ_url']); ?>" class="pull-right"> 
					<div id="siteLogo" style="float:right"></div>
					<div style="margin-top:5px;float: left; padding: 3px;font-weight: bold;font-size: 14pt;">
					پنل کاربری
					</div>
				</a>
            </div>
			<div class="span4  pull-right">
				<form class="navbar-form pull-left"  role="search" method="get" action="<?php echo $info['index_url']; ?>">
				  <input type="text" placeholder="جستجو …" value="" name="s" title="جستجو برای:" class="span2" style="height: inherit;">
				  <button onclick="this.submit()" class="btn" value=""><span class="icon-search" aria-hidden="true" value=""></span></button>
				</form>
			</div>
			<div  class="span4 pull-left" style="height:40px" >
				
				<div class="menu-image">
					
					<div class="menu_img">
						<img src="<?php echo $info['url']; ?>/panel/views/images/logo.png" title="admin2"/>
					</div>
				</div>
		

				<div id="menu-dd-container" class="menu-dd-container">
					<div class="menu-dd-content">
						
						<div class="menu-divider "></div>
						
						<div class="menu-divider "></div>
						<a href="<?php echo ( $info['usertype']==1 ?  $info['admin_url'] : $info['employ_url']); ?>" rel="loadpage">
							<div class="menu-dd-row">ناحیه کاربری</div>
						</a>
						
						<div class="menu-divider "></div>
						<a href="<?php echo $info['logout_url'] ?>">
							<div class="menu-dd-row">خروج</div>
						</a>
					</div>
				</div>
				<div class="search-container" style="display: none;"></div>
				<div id="menu-dd-container" class="menu-dd-container">
					<div class="menu-dd-content">
					
						<a href="<?php echo ( $info['usertype']==1 ?  $info['admin_url'] : $info['employ_url']); ?>" rel="loadpage"><div class="menu-dd-row menu-dd-mobile">ناحیه کاربری</div></a>
						<div class="menu-divider  menu-dd-mobile"></div>
						<a href="<?php echo $info['logout_url'] ?>"><div class="menu-dd-row">خروج</div></a>
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

