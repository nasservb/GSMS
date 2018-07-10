<div class="wrapper">

	<div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
	 

		<div class="logo">
			<a href="<?php echo $info['index_url'] ?>" class="simple-text">
				 <?php echo $info['page_title'] ?>
			</a>
		</div>

		<div class="sidebar-wrapper">
			<ul class="nav">
				<li class="active">
					<a href="<?php echo $info['login_url'] ?>">
						<i class="material-icons"></i>
						<p>ورود به سیستم</p>
					</a>
				</li>
				<?php
							foreach ($info['site_main_menu'] as $menu  )
							{
								echo '<li class="'.($info['activeTab']==$menu['tab'] ? 'active' : '').'">'; 
								echo '	<a href="'. $info['plugin_url'].$menu['url'].'">';
								echo '		<i class="material-icons ">'.$menu['icon'].'</i>';
								echo '		<p>'.$menu['title'].'</p>';
								echo '	</a>';
								echo '</li>';
							}							
						?>
			</ul>
		</div>
	</div>
	<div class="main-panel">
	
