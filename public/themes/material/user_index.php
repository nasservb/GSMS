
<div class="content">
	 <div class="container-fluid">
		<div class="col-md-12" >		
			<div class="card">
				<div class="card-header" data-background-color="<?=  $info['color'] ?>">
					<h4 class="title"><?= $info['title'] ?></h4>
					<p class="category"><?= (isset($info['title_tip'])? $info['title_tip'] : '' )  ?></p>
				</div>
				<div class="card-content">
				<?php echo $info['body']; ?>
				</div>
			</div> 
		</div>
	</div>		
</div>
	 
 