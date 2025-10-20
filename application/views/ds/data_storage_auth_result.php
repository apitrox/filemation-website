<style>
	body { background-color: #FFFFFF; }
	.config_wrapper {
		width: 650px;
		margin: auto;
	}	
</style>
<div class="container">
	<div id="Content" class="content-section">
		<div class="row">
			
			<div class="config_wrapper">
				<h3 class="<?php echo ($error) ? 'text-danger' : 'text-success'; ?>"><?php echo $return_message; ?></h3>
				<?php if( $error == FALSE ): ?>
					<hr/>
					<h4 class="text-muted">Next, setup the file definitions and file criteria..</h4>
					<p>
						To setup file definitions, and file criteria go to the <a href="/config/">Administration</a><br/><br/>
						- OR - <br/><br/>
						Click on the <i class="fa fa-cog"></i> <strong>Administration</strong> menu item under your username in the upper right hand corner. 
					</p>
				<?php else: ?>
					<hr/>
					<a href="/config/setupaccount/">Go back and authorize your data storage account</a>
				<?php endif; ?>
			</div>
			
		</div>
	</div>
</div>