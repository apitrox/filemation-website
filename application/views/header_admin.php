<?php $user_full_name = $this->auth_lib->GetUserFullName(); ?>
<nav class="navbar navbar-filemation navbar-static-top" role="navigation">
	<div class="container">
		<div class="row">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				  <span class="sr-only">Toggle navigation</span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				</button>
				<a id="FM_Account_Name" class="navbar-brand" href="/admin/errorlogreport">Admin</a>
			</div>
			<div class="collapse navbar-collapse" id="Nav_Right">
				<ul class="nav navbar-nav">

				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle text-darkgray" data-toggle="dropdown"><i class="fa fa-bars"></i> <?php echo $user_full_name; ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/admin/errorlogreport/"><i class="fa fa-file-text-o"></i> Error Log Report</a></li>
							<li class="divider"></li>
							<li><a href="/auth/logout/?redirect=admin"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>