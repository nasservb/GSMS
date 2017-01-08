<header> 

 
 
</div>
<div class="navbar navbar-default "  style="margin-bottom:0px">
      <div class="navbar-inner pinkMenu">
        <div class="row">   
			
			<div id="appIcon" class="span5 navbar-form pull-right">
				<a href="<?php echo $info['index_url']; ?>" class="pull-right"> <div id="siteLogo" ></div></a>

				 
            </div> 
			
			<div  class="span3  pull-right">
				<form class="navbar-form   pull-left"  role="search" method="POST" action="<?php echo $info['index']; ?>telgroups/search_result">
				    
				  
				</form>
			</div>
			<div id="loging" class="navbar-form pull-left">
				<ul class="nav navbar-nav"> 
					 
					<li><button  type="button" class="btn btn-default navbar-btn" onclick="window.open('<?php echo $info['login_url'] ?>')">ورود </button></li>
					
					
				</ul>
			</div>
		</div>
      </div>
</div> 

<div class="" align="center" style="background-color: #21AEEC;">
 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
	  
    <li  class="<?php echo ($info['activeTab'] =='telgroup' ? 'active' : '') ; ?>">
		<a href="<?php echo $info['index_url']; ?>"  >خانه
		<span class="icon-home" ></span>
		</a>
	</li>
   
 
	 
   
  
  </ul>
  

</div>

</header>