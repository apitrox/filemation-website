<style>
	.tt-dropdown-menu {
	position: absolute;
	top: 100%;
	left: 0;
	z-index: 1000;
	display: none;
	float: left;
	min-width: 160px;
	padding: 5px 0;
	margin: 2px 0 0;
	list-style: none;
	font-size: 14px;
	background-color: #ffffff;
	border: 1px solid #cccccc;
	border: 1px solid rgba(0, 0, 0, 0.15);
	border-radius: 4px;
	-webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
	box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
	background-clip: padding-box;
   }
   .tt-suggestion > p {
	display: block;
	padding: 3px 20px;
	clear: both;
	font-weight: normal;
	line-height: 1.428571429;
	color: #333333;
	white-space: nowrap;
   }
   .tt-suggestion > p:hover,
   .tt-suggestion > p:focus,
   .tt-suggestion.tt-cursor p {
	color: #ffffff;
	text-decoration: none;
	outline: 0;
	background-color: #428bca;
   }
   .tt-hint {
	   padding: 5px 11px;
	   color: #CCCCCC;
   }
</style>
<div class="">
	<div class="row">
	
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="states" class="typeahead form-control" type="text" placeholder="States of USA">

	</div>
</div>

<script type='text/javascript'>
	$('#states').typeahead({
		name: 'states',
		// data source
		prefetch: '/json/GetFileCriteriaRecallNames/?file_definition_id=1000000013&file_criteria_id=1000000210',

		// max item numbers list in the dropdown
		limit: 20
	});
	
</script>