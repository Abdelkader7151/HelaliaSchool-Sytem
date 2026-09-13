<?php if(isset($_SESSION['MM_Username']) && isset($_SESSION['admin'])){?>

 <div class="layout-footer">
	<div class="layout-footer-body">
	  <small class="version">Version 1.0</small>
	  <small class="copyright"><?php echo date("Y",time())?> &copy; All rights reserved </small>
	</div>
  </div>

<?php }else{?>

<div class="login-footer">
	<ul class="list-inline"> 
	  <li>©All rights reserved <strong><?php echo $row_get_settings['website_title_eng'];?></strong></li>
	</ul>
</div>

<?php }?>