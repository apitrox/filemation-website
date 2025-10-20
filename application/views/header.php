<?php $user_full_name = $this->auth_lib->GetUserFullName(); ?>
<?php $account_name = $this->auth_lib->GetAccountName(); ?>
<?php $account_id = $this->auth_lib->GetAccountId(); ?>
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
				<a id="FM_Account_Name" class="navbar-brand" href="/"><?php echo $account_name; ?></a>
			</div>
			<div class="collapse navbar-collapse" id="Nav_Right">
				<ul class="nav navbar-nav">

				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle text-darkgray" data-toggle="dropdown"><i class="fa fa-bars"></i> <?php echo $user_full_name; ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/docs/filer"><i class="fa fa-file-text-o"></i> File Documents</a></li>
							<li class="divider"></li>
							<li><a href="/account/"><i class="fa fa-cog"></i> Account Settings</a></li>
							<li><a href="/config/"><i class="fa fa-cogs"></i> Administration</a></li>
							<li class="divider"></li>
							<li><a href="/auth/logout"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>