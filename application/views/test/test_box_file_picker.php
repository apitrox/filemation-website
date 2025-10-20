<script type="text/javascript" src="https://app.box.com/js/static/select.js"></script>

<div class="container">
	<div class="row">
		<button id="Open_Filepicker_1" class="btn btn-default">Open Filepicker</button>
	</div>
	<br/>
	<div class="row">
		<div id="box-select" data-link-type="YOUR_LINK_TYPE" data-multiselect="YOUR_MULTISELECT" data-client-id="4fbszm4bfyxgficxrmbsznm0szq0x541"></div>
	</div>
</div>

<script type="text/javascript">
	// Configure the Box File Picker
	// -------------------------------
	var options = {
	    clientId: '4fbszm4bfyxgficxrmbsznm0szq0x541',
	    linkType: 'YOUR_LINK_TYPE',
	    multiselect: 'YOUR_MULTISELECT'
	};
	var boxSelect = new BoxSelect(options);

	// Subscribe to User Actions
	// -------------------------------
	// Register a success callback handler
	boxSelect.success(function(response) {
	    console.log(response);
	});
	// Register a cancel callback handler
	boxSelect.cancel(function() {
	    console.log("The user clicked cancel or closed the popup");
	});
	
	
	$('#Open_Filepicker_1').on('click', function(event){
		// Opens up the file picker window
		// Could use it to trigger a launch of the popup from your own button
		// NOTE: Should be triggered on a user action
		boxSelect.launchPopup();
	});
</script>