<footer class="footer">
	<div class="container-fluid">
		<nav class="pull-left">
			<ul>
				<li>
					<a href="<?php echo $info['index_url']; ?>question">
						سوال ها
					</a>
				</li>
				<li>
					<a href="<?php echo $info['index_url']; ?>help">
						راهنما
					</a>
				</li> 
				<li>
					<a href="<?php echo $info['index_url']; ?>contact">
					   تماس با ما
					</a>
				</li> 
				<li>
					<a href="<?php echo $info['index_url']; ?>about">
					   درباره ما
					</a>
				</li>
			</ul>
		</nav>
		<p class="copyright pull-right" align="center">

		Copyright : <a href="<?php echo $info['url']; ?>" style="font-size:14px;text-decoration:none"> <b><?php echo $info['copyright']; ?></b></a> <br/>
		
		<?php echo $info['footer_text']; ?>
		<a href="https://www.facebook.com/telegramgard/" target="_blank">فیسبوک</a>
		<a href="https://plus.google.com/b/107391192230960042852/107391192230960042852?gmbpt=true&hl=en" target="_blank">گوگل پلاس</a>
		
	</p>
		 
	</div>
</footer> 
 
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