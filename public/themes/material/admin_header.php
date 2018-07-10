<div class="wrapper">
	<div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">

				<div class="logo">
					<a href="#" class="simple-text">
					کنترل پنل  
					</a>
				</div>

				<div class="sidebar-wrapper">
					<ul class="nav">
						<li class="<?=($info['activeTab']=='dashboard'? 'active' : '')?>">
							<a href="<?php echo $info['admin_url']; ?>">
								<i class="material-icons">dashboard</i>
								<p>داشبورد</p>
							</a>
						</li>
						<li class="<?=($info['activeTab']=='orders'? 'active' : '')?>">
							<a href="<?php echo $info['admin_url']; ?>orders">
								<i class="material-icons">content_paste</i>
								<p>سفارش ها</p>
							</a>
						</li>
						<li class="<?=($info['activeTab']=='accounting'? 'active' : '')?>">
							<a href="<?php echo $info['admin_url']; ?>accounting">
								<i class="material-icons">credit_card</i>
								<p>امور مالی</p>
							</a>
						</li>
						<li class="<?=($info['activeTab']=='services'? 'active' : '')?>">
							<a href="<?php echo $info['admin_url']; ?>services">
								<i class="material-icons">web</i>
								<p>سرویس ها</p>
							</a>
						</li>
						<li class="<?=($info['activeTab']=='orderform'? 'active' : '')?>">
							<a href="<?php echo $info['admin_url']; ?>orderform">
								<i class="material-icons">chrome_reader_mode</i>
								<p>فرم ساز سفارش ها</p>
							</a>
						</li>
						<li class="<?=($info['activeTab']=='customers'? 'active' : '')?>">
							<a href="<?php echo $info['admin_url']; ?>customers">
								<i class="material-icons">person</i>
								<p>مشتریان</p>
							</a>
						</li>
						<?php
							foreach ($info['admin_main_menu'] as $menu  )
							{
								echo '<li class="'.($info['activeTab']==$menu['tab'] ? 'active' : '').'">'; 
								echo '	<a href="'. $info['plugin_url'].$menu['url'].'">';
								echo '		<i class="material-icons ">'.$menu['icon'].'</i>';
								echo '		<p>'.$menu['title'].'</p>';
								echo '	</a>';
								echo '</li>';
							}							
						?>
						
						<li >
							<a href="<?php echo $info['logout_url'] ?>">
								<i class="material-icons"></i>
								<p>خروج</p>
							</a>
						</li>
					</ul>
				</div>
			<div class="sidebar-background" style="background-image: url(<?php echo $info['theme_url']; ?>img/sidebar-1.jpg) "></div>
	</div>
			
	<div class="main-panel">	
		<nav class="navbar navbar-transparent navbar-absolute">
				<div class="container-fluid">
					<div class="pull-right navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"><?=$info['page_title']?></a>
					</div>
					<div class="collapse navbar-collapse">
						<form class="navbar-form navbar-left" role="search" action="<?= $info['admin_url']; ?>orders/search_result">
							<div class="form-group  is-empty">
	                        	<input type="text" name="id" class="form-control" placeholder="جستجوی سفارش">
	                        	<span class="material-input"></span>
							</div>
							<button title="جستجوی سفارش" type="submit" class="btn btn-white btn-round btn-just-icon">
								<i class="material-icons">search</i><div class="ripple-container"></div>
							</button>
	                    </form>
					</div>
				
				</div>
			</nav>
		 
		
		