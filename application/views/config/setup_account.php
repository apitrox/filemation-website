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
		<form id="Setup_Account_Data_Storage_Form">
			<div class="config_wrapper">
				<div id="Data_Storage_Edit_Wrapper" class="<?php echo ( empty($account->Data_Storage) || is_null($account->Data_Storage) || $account->Data_Storage == '' ) ? '' : 'hidden'; ?>">
					<div class="form-group">
						<div class="mb-20">
							<h3>First, select a data storage provider..</h3>
							<hr/>
							<p>We need you to select a data storage provider before you are able to rename and file your files. Select your <i>Data Storage</i> provider from the dropdown below,  and then click <i>Save Data Storage</i></p>
						</div>
						<label for="File_Storage" class="control-label font-normal text-muted">Data Storage</label>
						<div class="">			
							<select id="Data_Storage" name="Data_Storage" data-width="200px" class="form-control input-sm selectpicker">
								<option value=""></option>
								<?php if( count($data_storage_providers_array) > 0 ):?>
									<?php foreach($data_storage_providers_array as $option): ?>
										<option value="<?php echo $option['Data_Storage_Name']; ?>" <?php echo (strtoupper($account->Data_Storage) == strtoupper($option['Data_Storage_Name'])) ? "selected='selected'" : ""; ?>><?php echo $option['Data_Storage_Name']; ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div id="Data_Storage_Button_Wrapper" class="">
						<hr/>
						<button id="Data_Storage_Edit_Save" type="submit" class="btn btn-primary" data-loading-text="Saving..">Save Data Storage</button>
						<button id="Setup_Data_Storage_Edit_Cancel" type="cancel" class="btn btn-default hidden">Cancel</button>
					</div>
				</div>
				
				<div id="Data_Storage_Authorize_Wrapper" class="<?php echo ( !empty($account->Data_Storage) && !is_null($account->Data_Storage) && $account->Data_Storage != '' ) ? '' : 'hidden'; ?>">
					<div class="form-group">
						<h3>Next, authorize data storage account..</h3>
						<hr/>
						<p>After you have selected and saved a storage provider, you will need to <i>Authorize your Data Storage account</i>.</p>
					</div>
					<div class="form-group mt-20">
						<span class="text-muted">Data Storage Provider:</span> <span id="Data_Storage_Provider_Value"><?php echo $account->Data_Storage; ?></span>  <br/>
						<a href="#" class="change_data_storage_provider font-12">Change data storage provider</a>
					</div>
					<hr/>
					<div class="form-group mt-20">
						<button id="Authorize_Data_Storage" class="btn btn-primary" onclick="return false;">Authorize Data Storage</button><span class="arrow animated bounce"></span>
					</div>
				</div>
				
			</div>
			
		</form>
	</div>
</div>