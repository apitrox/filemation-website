<nav class="subnavbar navbar-fmsub navbar-static-top" role="navigation">
	<div class="container">
		<div class="row">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				  <span class="sr-only">Toggle navigation</span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="Nav_Right">
				<ul class="nav navbar-nav">
					<li class="<?php echo ( $page == 'Account') ? 'active' : ''; ?>"><a href="/config/account"><i class="fa fa-cloud text-muted"></i> Account</a></li>
					<li class="<?php echo ( $page == 'File Definitions') ? 'active' : ''; ?>"><a href="/config/filedefinitions"><i class="fa fa-tasks text-muted"></i> File Definitions</a></li>
					<li class="<?php echo ( $page == 'File Criteria') ? 'active' : ''; ?>"><a href="/config/filecriteria"><i class="fa fa-tags text-muted"></i> File Criteria</a></li>
					<li class="<?php echo ( $page == 'Users') ? 'active' : ''; ?>"><a href="/config/users"><i class="fa fa-users text-muted"></i> Users</a></li>
					<li class="<?php echo ( $page == 'Tools') ? 'active' : ''; ?>"><a href="/config/tools"><i class="fa fa-wrench text-muted"></i> Tools</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				</ul>
			</div>
		</div>
	</div>
</nav>
<nav class="navbar-fmsub-sub navbar-static-top" role="navigation">
	<div class="container">
		<div class="row">
			<h4><?php echo $page; ?></h4>
		</div>
	</div>
</nav>