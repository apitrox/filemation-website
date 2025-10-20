<div>
</div>

<?php $account_id = $this->auth_lib->GetAccountId(); ?>
<script type="text/javascript">
	///////////// TEMPORARY
	// this will be set on every page of the application
	// this will contain all of the user's session data in a javascript object to be referrenced later
	user_session = {
					account_id: '<?php echo $account_id; ?>'
				}
</script>
</body>
</html>