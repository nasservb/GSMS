	<div id="menu" class="container" align="center">
		<ul class="nav nav-pills span6" style="float:none">
			
			<li role="presentation"><a href="<?php echo $info['index_url']; ?>question">سوالات متداول</a></li>
			<li role="presentation"><a href="<?php echo $info['index_url']; ?>help">راهنما</a></li>
			<li role="presentation"><a href="<?php echo $info['index_url']; ?>rule">قوانین</a></li>
			<li role="presentation"><a href="<?php echo $info['index_url']; ?>contact">تماس با ما</a></li>
			<li role="presentation"><a href="<?php echo $info['index_url']; ?>about">درباره ما </a></li>
			
		</ul>
	</div>
<div id="footer"align="center">
	
	 <a href="<?php echo $info['url']; ?>" style="font-size:14px;text-decoration:none">چاپخانه پیام رسانه</a> <br/>
	<p face="IranianSerif-Regular" dir="rtl" style="font-size:14px"><?php echo $info['footer_text']; ?></p>
	<div style="display:none">
 
</div>
</div>

</div>
</div>

</body>

	<!--   Core JS Files   -->
	<script src="<?php echo $info['theme_url']; ?>js/jquery-3.1.0.min.js" type="text/javascript"></script>
	<script src="<?php echo $info['theme_url']; ?>js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo $info['theme_url']; ?>js/material.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="<?php echo $info['theme_url']; ?>js/chartist.min.js"></script>

	<!--  Notifications Plugin    -->
	<script src="<?php echo $info['theme_url']; ?>js/bootstrap-notify.js"></script>

	<!--  Google Maps Plugin    -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

	<!-- Material Dashboard javascript methods -->
	<script src="<?php echo $info['theme_url']; ?>js/material-dashboard.js"></script>

	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="<?php echo $info['theme_url']; ?>js/demo.js"></script>

	<script type="text/javascript">
    	$(document).ready(function(){

			// Javascript method's body can be found in assets/js/demos.js
        	demo.initDashboardPageCharts();

    	});
	</script>
	
</html>