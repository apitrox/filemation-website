<style>
	#Admin_Error_Log_Report_Grid tr td {
		border-right: 1px solid #CCCCCC;
		
	}
	#Admin_Error_Log_Report_Grid tr td:last-child {
		border-right: none;
	}
	#Admin_Error_Log_Report_Grid tr:last-child td {
		border-bottom: 1px solid #CCCCCC;
	}
	#Admin_Error_Log_Report_Grid_paginate {
		margin-right: 20px;
	}
</style>
<div class="container mt-20">
	<div class="row">
		<div class="pl-0 ml-0">
			<div class="panel panel-white">
				<div class="panel-heading mb-0">
					<h3 style="margin: 0px !important; padding: 0px !important;">Error Log Report</h3>
				</div>	
				<div class="panel-body p-0 list_filter">
					<table>
						<tr>
							<td>
								<label>Eariest Date:</label>
								<select id="" name="">
									<option value=""></option>
								</select>
							</td>
							<td>
								<label>Severity:</label>
								<select id="" name="">
									<option value=""></option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="panel-body p-0">
					
					<table id="Admin_Error_Log_Report_Grid" class="table table-striped" cellspacing="0" width="100%">
						<thead>
						    <tr>
								<th></th>
								<th>ID</th>
								<th>Date Time</th>
								<th>Severity</th>
								<th>Error Message</th>
								<th>File::Method<br/>Line</th>
								<th>user</th>
						    </tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>