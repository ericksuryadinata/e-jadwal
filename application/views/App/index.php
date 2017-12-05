<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <title>Dashboard</title>
        <?php $this->load->view('Partials/Back/Head')?>
        <?php $this->load->view('Partials/Back/Foot')?>
    </head>
    <body class="hold-transition skin-green sidebar-mini fixed">
        <div class="wrapper">  
      		<header class="main-header">
      			<a href="<?php echo site_url('MP_Back');?>" class="logo">
		          <!-- mini logo for sidebar mini 50x50 pixels -->
		          <span class="logo-mini"><b>J</b>DA</span>
		          <!-- logo for regular state and mobile devices -->
		          <span class="logo-lg"><b>Jadwal Dosen Untag</b></span>
		        </a>
		        <nav class="navbar navbar-static-top" role="navigation">
		          <!-- Sidebar toggle button-->
		          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		            <span class="sr-only">Toggle navigation</span>

		          </a>
		          <!--
		          <div class="navbar-custom-menu">
		          	<ul class="nav navbar-nav"> -->
		          		
		          		<!-- User Account: style can be found in dropdown.less -->
		              	<!--
		              	<li class="dropdown user user-menu">
			                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			                  <img src="assets/dist/img/avatar5.png" class="user-image">
			                  <span class="hidden-xs">Admin </span>
			                </a>

			                <ul class="dropdown-menu"> -->
			                	<!-- User image -->
			                	<!--
								<li class="user-header">
			                    	<img src="assets/dist/img/avatar5.png">
			                    	<p><small></small></p>
			                  	</li> -->
			                  	<!-- Menu Body -->
			                  	<!-- Menu Footer-->
			                  	<!--
			                  	<li class="user-footer">
			                    	<div class="pull-left">
			                        	<a href="profil.php">Profile</a>
			                        </div>
			                        <div class="pull-right">
			                            <a href="logout.php">Sign out</a>
			                        </div>
			                    </li>
			                </ul>
		              	</li>
		            </ul>
		          </div> -->
		        </nav>
		    </header>
		    <aside class="main-sidebar">
		        <div clas="user-panel">
		        	
		        </div>
		        <section class="sidebar" style="height:auto;">
		         	<ul class="sidebar-menu">
		         	    <li class="header">MAIN NAVIGATION</li>
	                        <li class="icn_view_users">
	                        	<a href="<?php echo site_url('MP_Back');?>">
	                        		<i class="fa fa-book"></i> <span>Jadwal Dosen</span>
	                        	</a>
	                        </li>
	                        <li class="icn_view_users">
	                        	<a href="<?php echo site_url('MP_Back/jadwal_tu');?>">
	                        		<i class="fa fa-book"></i> <span>Jadwal Tata Usaha</span>
	                        	</a>
	                        </li>
							<li class="icn_view_users">
	                        	<a href="<?php echo site_url('MP_Back/jadwal_bimbingan');?>">
	                        		<i class="fa fa-book"></i> <span>Jadwal Bimbingan Dosen</span>
	                        	</a>
	                        </li>
		         	</ul>
		        </section> 
		    </aside>
		    <!-- Dashboard-->
	</body>
</html>
			
    