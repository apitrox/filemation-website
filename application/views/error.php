<div class="container">
	<div id="Content" class="content-section">
		<div class="row">

			<div class="alert alert-danger">
				<p>
					<?php if( !empty($error_message) ): ?>
						<?php echo $error_message; ?><br/>
					<?php endif; ?>
					<?php if( !empty($error_log_id) ): ?>
						<strong>Error ID:</strong> <?php echo $error_log_id; ?>
					<?php endif; ?>
				</p>
			</div>
			
		</div>
	</div>
</div>