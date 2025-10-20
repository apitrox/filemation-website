<style>
	body {
		background-color: #FFFFFF !important;
	}
	.config_wrapper {
		width: 600px;
		margin: auto;
	}
</style>
<div class="container mt-20">
	<div class="row">
		
		<div class="config_wrapper">
			<div id="Show_Confirmation_Msg_Success" class="<?php echo ( $show_confirmation_message && $confirmation_result ) ? "" : "hidden"; ?>">
				<h3>Thank you, your email is confirmed</h3>
				<p class="count_down_container">You will be redirected in <span class="count_down">3</span> seconds</p>
			</div>
			<div id="Show_Confirmation_Msg_Error" class="<?php echo ( $show_confirmation_message && !$confirmation_result ) ? "" : "hidden"; ?>">
				<h3>Sorry, your email did not confirm correctly.</h3>
				<p>Either the confirmation code was incorrect, or this account does not exist. Would you like to <a href="/auth/confirm">try again</a>? If you need to resend the confirmation email click <a href="#" class="confirm_resend_confirmation_email" rel="<?php echo $user_id; ?>">here</a>.</p>
			</div>
			<div id="Confirmation_Form" class="<?php echo ( !$show_confirmation_message ) ? "" : "hidden"; ?>">
				<h3>You're almost there. We just need to confirm your email address.</h3>
				<p>Check your inbox for an email from Filemation with the subject <i>Confirm your email address</i>. If you do not see the email in your inbox, check your <i>spam</i> or your <i>junk</i> box.</p>
				<p><a href="#" class="confirm_resend_confirmation_email" rel="<?php echo $user_id; ?>">Resend confirmation email</a></p>
				<hr/>
				<div class="form-group">
					<label class="form-label" for="Confirmation_Code">If you have the confirmation code enter it in the text field below.</label>
					<input type="text" id="Confirmation_Code" name="Confirmation_Code" class="form-control input-sm" placeholder="Confirmation Code" />
				</div>
				<div class="form-group">
					<button id="Confirm_Email_Address" class="btn btn-primary btn-sm" data-loading-state="Confirming..">Confirm email address</button>
				</div>
			</div>
		</div>
		
	</div>
</div>
<?php if( $show_confirmation_message && $confirmation_result ): ?>
	<script type="text/javascript">
		$(function(){
			setTimeout( "$('.count_down').text('2')", 1200 );
			setTimeout( "$('.count_down').text('1')", 2200 );
			setTimeout( "$('.count_down_container').text('Hold on, we are redirecting to filemation.')", 3100 );
			setTimeout( "document.location.href='https://dev.filemation.com/'", 3200 );
		});
	</script>
<?php else: ?>
	<script type="text/javascript">
		$(function(){
			$('#Confirm_Email_Address').on('click', function(){
				var confirmation_key = $('#Confirmation_Code').val();
				
				$.ajax({
					url: '/auth/ConfirmEmailConfirmationKey/',
					data: {'Con_Key': confirmation_key},
					type: 'POST',
					dataType: 'json',
					error: function(xhr){
						AjaxError(xhr);
					},
					success: function(response){
						if( typeof response.Result != 'undefined' && response.Result == true )
						{
							if( typeof response.Valid != 'undefined' && response.Valid == true )
							{
								$('#Show_Confirmation_Msg_Success').removeClass('hidden').show();
								$('#Confirmation_Form').hide();
								setTimeout( "$('.count_down').text('2')", 1200 );
								setTimeout( "$('.count_down').text('1')", 2200 );
								setTimeout( "$('.count_down_container').text('Hold on, we are redirecting to filemation.')", 3100 );
								setTimeout( "document.location.reload()", 3200 );
							}
							else
							{
								$('#Show_Confirmation_Msg_Error').removeClass('hidden').show();
								$('#Confirmation_Form').hide();
							}
						}
						else
						{
							var error_message = ( typeof response.Error_Message != 'undefined' ) ? response.Error_Message : '';
							$().Notification(error_message);
						}
					}
				});
			});
		});
	</script>
<?php endif; ?>
